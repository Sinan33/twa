<?php
// Start session
session_start();

// Handle login from form submission
if (isset($_POST['auth']) && $_POST['auth'] === 'true') {
    $_SESSION['admin_logged_in'] = true;
    // Redirect to prevent form resubmission on refresh
    header('Location: dashboard.php');
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin.php'); // Redirect to login page if not logged in
    exit;
}

// Handle logout
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset();
    session_destroy();
    header('Location: admin.php'); // Redirect to login page after logout
    exit;
}

// Include database connection (ensure this path is correct)
require_once 'config.php';

// --- Database Deletion Logic ---
if (isset($_POST['delete_user']) && !empty($_POST['user_id'])) {
    $userId = intval($_POST['user_id']); // Sanitize input

    // Start a transaction to ensure data consistency
    $conn->begin_transaction();

    try {
        // Use prepared statements for security
        // First delete from test_results (child table with foreign key)
        $stmtResults = $conn->prepare("DELETE FROM test_results WHERE user_id = ?");
        $stmtResults->bind_param("i", $userId);
        if (!$stmtResults->execute()) {
            throw new Exception("فشل في حذف نتائج الاختبار: " . $stmtResults->error);
        }
        $stmtResults->close();

        // Then delete from users table
        $stmtUser = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmtUser->bind_param("i", $userId);
        if (!$stmtUser->execute()) {
            throw new Exception("فشل في حذف بيانات المستخدم: " . $stmtUser->error);
        }
        $stmtUser->close();

        // Commit transaction
        $conn->commit();

        // Set success message and redirect to refresh the page, pointing to the results section
        $_SESSION['delete_success'] = "تم حذف نتائج المستخدم بنجاح.";
        header('Location: dashboard.php#results');
        exit;

    } catch (Exception $e) {
        // Roll back transaction on error
        $conn->rollback();
        $_SESSION['delete_error'] = $e->getMessage();
        // Redirect back to the results section even on error
        header('Location: dashboard.php#results');
        exit;
    }
}
// --- End Deletion Logic ---


// --- Fetch Data for Dashboard ---
$resultsData = [];
$totalTests = 0;
$countA = 0;
$countB = 0;
$countC = 0;
$countD = 0;

// Use prepared statement for fetching data
$sql = "SELECT u.id, u.full_name, u.email, u.phone, u.gender, u.test_date,
               r.score_a, r.score_b, r.score_c, r.score_d, r.dominant_category
        FROM users u
        JOIN test_results r ON u.id = r.user_id
        ORDER BY u.test_date DESC";

$result = $conn->query($sql);

if ($result) {
    $totalTests = $result->num_rows;
    while ($row = $result->fetch_assoc()) {
        $resultsData[] = $row; // Store data for table rendering

        // Count dominant categories
        switch ($row['dominant_category']) {
            case 'A': $countA++; break;
            case 'B': $countB++; break;
            case 'C': $countC++; break;
            case 'D': $countD++; break;
        }
    }
    // No need to reset pointer, data is stored in $resultsData
} else {
    // Handle potential query error (optional: log error)
    $_SESSION['data_error'] = "حدث خطأ أثناء جلب البيانات: " . $conn->error;
}

// Close the connection (optional, PHP usually handles this at script end)
// $conn->close();
// --- End Fetch Data ---

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم اختبار توازن</title>

    <link rel="icon" href="log.png" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.rtl.min.css" integrity="sha512-tQ3gsSPzpZf66J4hFSzMv4nGr1cM3HcFkPGsNfHNJmAeAMJj+1MPYpTGJCNFDB6o/jSvQdjfJj6NqP8rZt1ZUg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css"> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* --- Base Styles & Variables --- */
        :root {
            --primary: #54c8e8;
            --primary-dark: #083347;
            --primary-light: rgba(84, 200, 232, 0.153);
            --secondary: #8ad7ed; /* Consider using this more */
            --white: #ffffff;
            --dark: #083347; /* Same as primary-dark, maybe rename? */
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --gray-800: #343a40;
            --gray-900: #212529;
            --border: #e2e8f0;
            --text-primary: #083347;
            --text-secondary: #4a6e7d;
            --text-muted: #b2bec3;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #54c8e8; /* Same as primary */
            --font-main: 'Tajawal', sans-serif;
            --shadow-sm: 0 2px 4px rgba(8, 51, 71, 0.05);
            --shadow: 0 4px 6px rgba(8, 51, 71, 0.1);
            --shadow-md: 0 10px 15px -3px rgba(8, 51, 71, 0.1), 0 4px 6px -2px rgba(8, 51, 71, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(8, 51, 71, 0.1), 0 10px 10px -5px rgba(8, 51, 71, 0.04);
            --shadow-hover: 0 10px 20px rgba(8, 51, 71, 0.15);
            --radius-sm: 0.25rem;
            --radius: 0.5rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
            --radius-full: 9999px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --sidebar-width: 280px;
            --sidebar-width-collapsed: 70px;
            --mobile-nav-height: 70px;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-main);
            background-color: #f0f5f9;
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
            padding-bottom: var(--mobile-nav-height); /* Space for mobile navigation */
            display: flex; /* Use flex for main layout */
        }

        /* --- Layout --- */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(165deg, var(--primary-dark) 0%, #06232f 100%);
            color: var(--white);
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0; /* RTL */
            overflow-y: auto;
            z-index: 1040;
            transition: width var(--transition), transform var(--transition);
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.07);
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex-grow: 1;
            padding: 1.5rem;
            margin-right: var(--sidebar-width); /* RTL */
            transition: margin-right var(--transition);
            min-width: 0; /* Prevent content overflow */
        }

        .content-wrapper {
            max-width: 1600px;
            margin: 0 auto;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1030; /* Below sidebar */
            cursor: pointer;
        }
        .overlay.active {
            display: block;
        }

        /* --- Sidebar Styles --- */
        .sidebar-header {
            padding: 1.75rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }
        .sidebar-header::before { /* Subtle gradient effect */
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.06) 0%, transparent 70%);
            pointer-events: none;
        }
        .sidebar-logo {
            width: 80px; height: 80px;
            border-radius: var(--radius-full);
            margin-bottom: 1rem;
            object-fit: cover;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.07), var(--shadow-md);
            transition: var(--transition);
            background-color: rgba(255, 255, 255, 0.05);
            padding: 0.5rem;
            backdrop-filter: blur(5px);
        }
        .sidebar-title {
            font-size: 1.5rem; font-weight: 700;
            margin-bottom: 0.35rem;
            background: linear-gradient(90deg, #fff, rgba(255, 255, 255, 0.7));
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: opacity var(--transition);
        }
        .sidebar-subtitle {
            font-size: 0.9rem; opacity: 0.7; font-weight: 400;
            transition: opacity var(--transition);
        }

        .nav-menu {
            list-style: none; padding: 1.5rem 1rem; margin: 0;
            flex-grow: 1; /* Takes remaining space */
            overflow-y: auto; /* Allows scrolling if needed */
        }
        .nav-item { margin-bottom: 0.75rem; }
        .nav-link {
            display: flex; align-items: center; gap: 0.875rem;
            padding: 0.875rem 1.25rem;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            border-radius: var(--radius-lg);
            font-weight: 500;
            transition: background-color var(--transition), color var(--transition), padding var(--transition);
            position: relative; overflow: hidden;
        }
        .nav-link::before { /* Hover background effect */
            content: ''; position: absolute; top: 0; left: 0;
            width: 0; height: 100%;
            background-color: rgba(255, 255, 255, 0.1);
            transition: width 0.3s ease;
            z-index: -1; /* Place behind content */
        }
        .nav-link:hover, .nav-link:focus {
            color: var(--white);
            background-color: rgba(255, 255, 255, 0.05); /* Subtle hover background */
            outline: none;
        }
        .nav-link:hover::before { width: 100%; }
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            font-weight: 600;
        }
        .nav-link.active::after { /* Active indicator */
            content: ''; position: absolute; top: 0; right: 0; /* RTL */
            width: 4px; height: 100%;
            background: var(--primary);
            border-radius: 2px 0 0 2px; /* RTL */
        }
        .nav-icon {
            width: 1.25rem; height: 1.25rem;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.1rem; transition: transform var(--transition);
            flex-shrink: 0; /* Prevent shrinking when text is long */
        }
        .nav-link:hover .nav-icon, .nav-link.active .nav-icon { transform: scale(1.1); }
        .nav-text {
            font-size: 0.95rem;
            white-space: nowrap; /* Prevent text wrapping */
            overflow: hidden; /* Hide text when sidebar collapses */
            transition: opacity var(--transition);
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            margin-top: auto; /* Pushes footer to bottom */
            flex-shrink: 0;
        }
        .logout-btn {
            display: flex; align-items: center; justify-content: center; gap: 0.75rem;
            width: 100%; padding: 0.875rem 1.25rem;
            background: rgba(231, 76, 60, 0.15); color: #fff;
            border: none; border-radius: var(--radius);
            cursor: pointer; font-weight: 500;
            transition: var(--transition); text-decoration: none;
            position: relative; overflow: hidden; backdrop-filter: blur(5px);
        }
        .logout-btn::before { /* Shine effect */
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%); transition: transform 0.6s ease;
        }
        .logout-btn:hover, .logout-btn:focus {
            background: rgba(231, 76, 60, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.2);
            outline: none;
            color: #fff;
        }
        .logout-btn:hover::before { transform: translateX(100%); }
        .logout-text { transition: opacity var(--transition); }

        /* --- Main Content Header --- */
        .main-header {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; /* Allow wrapping on small screens */
            gap: 1rem; /* Space between items */
            margin-bottom: 2rem;
            background-color: var(--white);
            padding: 1.25rem 1.75rem;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            position: relative; overflow: hidden;
        }
        .main-header::before { /* Top border gradient */
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        }
        .header-title {
            font-size: 1.5rem; font-weight: 700; color: var(--dark);
            margin: 0; /* Remove default margin */
        }
        .date-display {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.5rem 1rem; background-color: var(--gray-100);
            border-radius: var(--radius); font-weight: 500;
            color: var(--text-secondary); font-size: 0.9rem;
            flex-shrink: 0; /* Prevent shrinking */
        }

        /* --- Cards --- */
        .card {
            background-color: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 2rem;
            transition: var(--transition);
            border: none;
            transform: translateY(0);
        }
        .card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-5px);
        }
        .card-header {
            padding: 1.5rem 1.75rem; position: relative; overflow: hidden;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white); font-weight: 700; font-size: 1.25rem;
            display: flex; align-items: center; gap: 0.75rem;
            border-bottom: none;
        }
        .card-header::before { /* Subtle gradient */
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        .card-header .header-icon { font-size: 1.25rem; }
        .card-body { padding: 1.75rem; }

        /* --- Stats Cards --- */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); /* Responsive grid */
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background-color: var(--white); border-radius: var(--radius-xl);
            box-shadow: var(--shadow); padding: 1.75rem;
            display: flex; align-items: center; gap: 1.25rem;
            transition: var(--transition); position: relative; overflow: hidden;
            border: none; transform: translateY(0);
        }
        .stat-card::before { /* Top border hover effect */
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--primary), transparent);
            opacity: 0; transition: var(--transition);
        }
        .stat-card:hover {
            transform: translateY(-7px); box-shadow: var(--shadow-hover);
        }
        .stat-card:hover::before { opacity: 1; }
        .stat-icon {
            width: 3.5rem; height: 3.5rem; border-radius: var(--radius-full);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; flex-shrink: 0;
            transition: var(--transition);
        }
        .stat-card:hover .stat-icon { transform: scale(1.1); }
        /* Icon Backgrounds */
        .stat-icon-blue { background: linear-gradient(135deg, rgba(84, 200, 232, 0.15) 0%, rgba(84, 200, 232, 0.3) 100%); color: var(--primary); }
        .stat-icon-green { background: linear-gradient(135deg, rgba(46, 204, 113, 0.15) 0%, rgba(46, 204, 113, 0.3) 100%); color: var(--success); }
        .stat-icon-orange { background: linear-gradient(135deg, rgba(243, 156, 18, 0.15) 0%, rgba(243, 156, 18, 0.3) 100%); color: var(--warning); }
        .stat-icon-red { background: linear-gradient(135deg, rgba(231, 76, 60, 0.15) 0%, rgba(231, 76, 60, 0.3) 100%); color: var(--danger); }
        .stat-content { flex-grow: 1; min-width: 0; /* Prevent overflow */ }
        .stat-value {
            font-size: 2rem; font-weight: 700; margin-bottom: 0.25rem; line-height: 1.2;
            background: linear-gradient(90deg, var(--dark), var(--gray-700));
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
            word-break: break-all; /* Prevent long numbers from breaking layout */
        }
        .stat-label { color: var(--text-secondary); font-size: 0.95rem; font-weight: 500; }

        /* --- Chart --- */
        .chart-container { height: 350px; margin-top: 1rem; }

        /* --- DataTables --- */
        .table-container {
             border-radius: var(--radius-lg);
             overflow: hidden; /* Clips table corners */
             background-color: var(--white); /* Needed if table itself is transparent */
             padding: 0;
             width: 100%;
        }
        
        .dataTables_wrapper {
            padding: 0;
            width: 100%;
        }
        
        .dataTables_wrapper .dt-buttons {
             margin-bottom: 1rem;
             float: right;
        }
        
        .dataTables_wrapper .dt-buttons .btn {
             margin-left: 0.5rem;
             border-radius: var(--radius);
             box-shadow: var(--shadow-sm);
             transition: var(--transition);
        }
        
        .dataTables_wrapper .dt-buttons .btn:hover {
             transform: translateY(-2px);
             box-shadow: var(--shadow);
        }

        .dataTables_filter { float: left; }

        table.dataTable {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0 !important;
        }
        
        table.dataTable thead th {
            background-color: rgba(8, 51, 71, 0.03);
            color: var(--text-primary);
            font-weight: 600;
            border-bottom: 2px solid var(--border);
            padding: 1.25rem 1rem;
            text-align: right;
            position: relative;
            white-space: nowrap;
        }
        
        table.dataTable thead th::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), transparent);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        
        table.dataTable thead th.sorting:hover::after,
        table.dataTable thead th.sorting_asc::after,
        table.dataTable thead th.sorting_desc::after { transform: scaleX(1); }

        table.dataTable tbody td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            transition: background-color var(--transition);
        }
        
        table.dataTable tbody tr:last-child td { border-bottom: none; }
        table.dataTable tbody tr { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        
        table.dataTable tbody tr:hover {
            background-color: rgba(84, 200, 232, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            cursor: default;
        }
        
        /* DataTables Controls Styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 1.25rem;
            color: var(--text-secondary);
        }
        
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            background-color: var(--white);
        }
        
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(84, 200, 232, 0.2);
            outline: none;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: var(--radius);
            background-color: var(--gray-100);
            border: none !important;
            transition: var(--transition);
            color: var(--text-secondary) !important;
            box-shadow: var(--shadow-sm);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: var(--primary-light) !important;
            color: var(--primary-dark) !important;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
            color: white !important;
            box-shadow: var(--shadow);
            transform: translateY(-1px);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        /* Table scrolling */
        .dataTables_wrapper .dataTables_scroll {
            margin-bottom: 1rem;
        }
        
        .dataTables_scrollHead, .dataTables_scrollBody {
            width: 100% !important;
        }
        
        .dataTables_scroll .dataTables_scrollBody::-webkit-scrollbar {
            height: 8px;
            background-color: var(--gray-100);
            border-radius: var(--radius-full);
        }
        
        .dataTables_scroll .dataTables_scrollBody::-webkit-scrollbar-thumb {
            background-color: var(--primary-light);
            border-radius: var(--radius-full);
        }
        
        .dataTables_scroll .dataTables_scrollBody::-webkit-scrollbar-thumb:hover {
            background-color: var(--primary);
        }

        /* --- Profile Badges --- */
        .profile-type {
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius-full);
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            white-space: nowrap;
        }
        
        .profile-type:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        
        /* Badge Colors */
        .profile-type-a { background: linear-gradient(135deg, rgba(84, 200, 232, 0.15) 0%, rgba(84, 200, 232, 0.3) 100%); color: var(--primary); }
        .profile-type-b { background: linear-gradient(135deg, rgba(46, 204, 113, 0.15) 0%, rgba(46, 204, 113, 0.3) 100%); color: var(--success); }
        .profile-type-c { background: linear-gradient(135deg, rgba(243, 156, 18, 0.15) 0%, rgba(243, 156, 18, 0.3) 100%); color: var(--warning); }
        .profile-type-d { background: linear-gradient(135deg, rgba(231, 76, 60, 0.15) 0%, rgba(231, 76, 60, 0.3) 100%); color: var(--danger); }
        .profile-type i { font-size: 0.9em; }

        /* --- Action Buttons (Table) --- */
        .action-buttons {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }
        
        .btn-action {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: var(--radius-full);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            font-size: 0.9rem;
            text-decoration: none;
        }
        
        .btn-action:hover, .btn-action:focus {
            transform: translateY(-3px) scale(1.1);
            box-shadow: var(--shadow);
            outline: none;
        }
        
        .btn-view { background: linear-gradient(135deg, rgba(84, 200, 232, 0.15) 0%, rgba(84, 200, 232, 0.3) 100%); color: var(--primary); }
        .btn-view:hover, .btn-view:focus { background: var(--primary); color: var(--white); }
        .btn-delete { background: linear-gradient(135deg, rgba(231, 76, 60, 0.15) 0%, rgba(231, 76, 60, 0.3) 100%); color: var(--danger); }
        .btn-delete:hover, .btn-delete:focus { background: var(--danger); color: var(--white); }

        /* --- Alert Messages --- */
        .alert {
            padding: 1.25rem 1.5rem;
            border-radius: var(--radius-xl);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: none;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 5px;
        }
        
        .alert-success { background: linear-gradient(135deg, rgba(46, 204, 113, 0.1) 0%, rgba(46, 204, 113, 0.2) 100%); color: #1a6e3b; }
        .alert-success::before { background: var(--success); }
        .alert-danger { background: linear-gradient(135deg, rgba(231, 76, 60, 0.1) 0%, rgba(231, 76, 60, 0.2) 100%); color: #8b2c22; }
        .alert-danger::before { background: var(--danger); }
        .alert-info { background: linear-gradient(135deg, rgba(84, 200, 232, 0.1) 0%, rgba(84, 200, 232, 0.2) 100%); color: #0f6f8a; }
        .alert-info::before { background: var(--info); }
        .alert-icon { font-size: 1.5rem; flex-shrink: 0; }
        .alert-content { flex-grow: 1; font-weight: 500; }
        .alert .btn-close { filter: grayscale(1) brightness(1.5); }

        /* --- Mobile Navigation --- */
        .mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(180deg, rgba(6, 35, 47, 0.95) 0%, rgba(8, 51, 71, 0.98) 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            z-index: 1050;
            box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.1);
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
            height: var(--mobile-nav-height);
        }
        
        .mobile-nav-menu {
            display: flex;
            justify-content: space-around;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            height: 100%;
        }
        
        .mobile-nav-item { flex: 1; text-align: center; }
        
        .mobile-nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            padding: 0.25rem 0;
            font-size: 0.7rem;
            font-weight: 500;
            transition: var(--transition);
            border-radius: var(--radius);
            position: relative;
            height: 100%;
        }
        
        .mobile-nav-link::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: var(--primary);
            border-radius: var(--radius-full);
            transition: var(--transition);
            opacity: 0;
        }
        
        .mobile-nav-link.active { color: var(--white); }
        .mobile-nav-link.active::after { width: 20px; opacity: 1; }
        .mobile-nav-icon { font-size: 1.5rem; margin-bottom: 0.15rem; transition: var(--transition); }
        .mobile-nav-link:hover, .mobile-nav-link.active { color: var(--white); }
        .mobile-nav-link:hover .mobile-nav-icon, .mobile-nav-link.active .mobile-nav-icon { transform: translateY(-2px); }
        .mobile-nav-text { font-size: 0.75rem; }

        /* --- Mobile Floating Buttons --- */
        .mobile-fab {
            display: none;
            position: fixed;
            width: 50px;
            height: 50px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            box-shadow: var(--shadow-md);
            z-index: 1045;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            cursor: pointer;
        }
        
        .mobile-fab:hover { transform: scale(1.1) translateY(-2px); box-shadow: var(--shadow-lg); }
        #refreshBtn { bottom: calc(var(--mobile-nav-height) + 20px); left: 20px; }
        #sidebarToggleBtn { bottom: calc(var(--mobile-nav-height) + 20px); right: 20px; }

        /* --- Animations --- */
        .pulse { animation: pulse 2s infinite cubic-bezier(0.4, 0, 0.6, 1); }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* --- SweetAlert RTL --- */
        .swal-rtl .swal2-popup { direction: rtl; font-family: var(--font-main); }
        .swal-rtl .swal2-title { text-align: right; }
        .swal-rtl .swal2-html-container { text-align: right; }
        .swal-rtl .swal2-actions { justify-content: flex-start; }

        /* --- Responsive Design --- */

        /* Medium Devices (Tablets, smaller desktops) */
        @media (max-width: 991.98px) {
            .sidebar { width: var(--sidebar-width-collapsed); }
            .sidebar .sidebar-title,
            .sidebar .sidebar-subtitle,
            .sidebar .nav-text,
            .sidebar .logout-text {
                opacity: 0;
                pointer-events: none;
            }
            .sidebar .nav-link { padding: 0.75rem; justify-content: center; }
            .sidebar .logout-btn { padding: 0.75rem; justify-content: center; }
            .sidebar .sidebar-logo { width: 40px; height: 40px; margin-bottom: 0.5rem; padding: 0.25rem;}

            /* Expanded state for collapsed view */
            .sidebar.expanded { width: var(--sidebar-width); }
            .sidebar.expanded .sidebar-title,
            .sidebar.expanded .sidebar-subtitle,
            .sidebar.expanded .nav-text,
            .sidebar.expanded .logout-text {
                opacity: 1;
                pointer-events: auto;
            }
            .sidebar.expanded .nav-link { padding: 0.875rem 1.25rem; justify-content: flex-start; }
            .sidebar.expanded .logout-btn { padding: 0.875rem 1.25rem; justify-content: center; }
            .sidebar.expanded .sidebar-logo { width: 80px; height: 80px; margin-bottom: 1rem; padding: 0.5rem;}


            .main-content { margin-right: var(--sidebar-width-collapsed); }
            .main-content.expanded { margin-right: var(--sidebar-width); }

            #sidebarToggleBtn { display: flex; }
            
            /* Adjust FAB positions */
            #refreshBtn { bottom: 20px; }
        }

        /* Small Devices (Landscape Phones, Tablets Portrait) */
        @media (max-width: 767.98px) {
            body { padding-bottom: var(--mobile-nav-height); }
            .sidebar {
                transform: translateX(100%);
                width: var(--sidebar-width);
                z-index: 1060;
            }
            .sidebar.mobile-visible { transform: translateX(0); }

            /* Ensure text is visible when sidebar is open on mobile */
            .sidebar .sidebar-title,
            .sidebar .sidebar-subtitle,
            .sidebar .nav-text,
            .sidebar .logout-text {
                opacity: 1;
                pointer-events: auto;
            }
            .sidebar .nav-link { padding: 0.875rem 1.25rem; justify-content: flex-start; }
            .sidebar .logout-btn { padding: 0.875rem 1.25rem; justify-content: center; }
            .sidebar .sidebar-logo { width: 80px; height: 80px; margin-bottom: 1rem; padding: 0.5rem;}


            .main-content { margin-right: 0; padding: 1.5rem 1rem; }
            .main-content.expanded { margin-right: 0; }

            .stats-container { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; }
            .stat-card { padding: 1.25rem; }
            .stat-icon { width: 3rem; height: 3rem; font-size: 1.25rem; }
            .stat-value { font-size: 1.75rem; }

            .main-header { padding: 1.25rem; }

            .mobile-nav { display: block; }
            .mobile-fab { display: flex; }
            #sidebarToggleBtn {
                 bottom: calc(var(--mobile-nav-height) + 20px);
                 right: 20px;
            }
             #refreshBtn {
                 bottom: calc(var(--mobile-nav-height) + 20px);
                 left: 20px;
             }

            /* Make export buttons responsive */
            .dataTables_wrapper .dt-buttons { 
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
             }
            .dataTables_filter { float: none; text-align: center; margin-bottom: 1rem;}
            .dataTables_length { float: none; text-align: center;}
        }

        /* Extra Small Devices (Phones Portrait) */
        @media (max-width: 575.98px) {
            .stats-container { grid-template-columns: 1fr; }
            .card-header, .card-body { padding: 1.25rem; }
            .action-buttons { gap: 0.5rem; }
            .chart-container { height: 300px; }
            .profile-type { font-size: 0.8rem; padding: 0.4rem 0.6rem; }
            .main-content { padding: 1rem; padding-bottom: calc(var(--mobile-nav-height) + 1rem); }
            .card, .stat-card { border-radius: var(--radius-lg); }
            .header-title { font-size: 1.3rem; }
            .date-display { font-size: 0.8rem; padding: 0.4rem 0.8rem; }

            /* Stack table controls */
            .dataTables_wrapper .top-controls {
                display: flex;
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
            }
             .dataTables_wrapper .dataTables_length,
             .dataTables_wrapper .dataTables_filter {
                 text-align: center;
                 width: 100%;
                 padding: 0.5rem 0;
             }
              .dataTables_wrapper .dataTables_filter input,
              .dataTables_wrapper .dataTables_length select {
                  width: 100%;
                  margin: 0;
              }
             .dataTables_paginate .paginate_button { padding: 0.4rem 0.6rem; font-size: 0.9rem;}
        }

    </style>
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="log.png" alt="Logo" class="sidebar-logo">
            <h1 class="sidebar-title">لوحة التحكم</h1>
            <div class="sidebar-subtitle">اختبار توازن للشخصية</div>
        </div>

        <nav class="nav-menu">
            <ul>
                <li class="nav-item">
                    <a href="#dashboard-section" class="nav-link active">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <span class="nav-text">الإحصائيات</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#results-section" class="nav-link">
                        <i class="fas fa-list-alt nav-icon"></i>
                        <span class="nav-text">نتائج الاختبارات</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="test.php" class="nav-link" target="_blank" rel="noopener noreferrer">
                        <i class="fas fa-external-link-alt nav-icon"></i>
                        <span class="nav-text">صفحة الاختبار</span>
                    </a>
                </li>
                 </ul>
        </nav>

        <div class="sidebar-footer">
            <a href="?logout=true" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span class="logout-text">تسجيل الخروج</span>
            </a>
        </div>
    </aside>

    <main class="main-content" id="mainContent">
        <div class="content-wrapper">

            <header class="main-header" data-aos="fade-down">
                <h1 class="header-title">لوحة تحكم اختبار توازن</h1>
                <div class="date-display">
                    <i class="far fa-calendar-alt"></i>
                    <span><?php echo date('Y-m-d'); ?></span>
                </div>
            </header>

            <?php if (isset($_SESSION['delete_success'])): ?>
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                    <i class="fas fa-check-circle alert-icon"></i>
                    <div class="alert-content"><?php echo htmlspecialchars($_SESSION['delete_success']); ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['delete_success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['delete_error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                    <i class="fas fa-exclamation-circle alert-icon"></i>
                    <div class="alert-content">حدث خطأ: <?php echo htmlspecialchars($_SESSION['delete_error']); ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['delete_error']); ?>
            <?php endif; ?>

             <?php if (isset($_SESSION['data_error'])): ?>
                <div class="alert alert-warning alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                    <i class="fas fa-exclamation-triangle alert-icon"></i>
                    <div class="alert-content">خطأ في البيانات: <?php echo htmlspecialchars($_SESSION['data_error']); ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['data_error']); ?>
            <?php endif; ?>


            <section id="dashboard-section" class="mb-4">

                <div class="stats-container" data-aos="fade-up">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-blue"><i class="fas fa-users"></i></div>
                        <div class="stat-content">
                            <div class="stat-value" id="totalTestsStat"><?php echo $totalTests; ?></div>
                            <div class="stat-label">إجمالي الاختبارات</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-blue"><i class="fas fa-brain"></i></div>
                        <div class="stat-content">
                            <div class="stat-value" id="countAStat"><?php echo $countA; ?></div>
                            <div class="stat-label">المنطقي التحليلي (A)</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-green"><i class="fas fa-tasks"></i></div>
                        <div class="stat-content">
                            <div class="stat-value" id="countBStat"><?php echo $countB; ?></div>
                            <div class="stat-label">المنظم التنفيذي (B)</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-orange"><i class="fas fa-heart"></i></div>
                        <div class="stat-content">
                            <div class="stat-value" id="countCStat"><?php echo $countC; ?></div>
                            <div class="stat-label">العاطفي الاجتماعي (C)</div>
                        </div>
                    </div>
                     <div class="stat-card">
                        <div class="stat-icon stat-icon-red"><i class="fas fa-lightbulb"></i></div>
                        <div class="stat-content">
                            <div class="stat-value" id="countDStat"><?php echo $countD; ?></div>
                            <div class="stat-label">الابتكاري الاستراتيجي (D)</div>
                        </div>
                    </div>
                </div>

                <div class="card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header">
                        <i class="fas fa-chart-pie header-icon"></i>
                        <span>توزيع أنماط الشخصية</span>
                    </div>
                    <div class="card-body">
                        <div id="profileChart" class="chart-container"></div>
                    </div>
                </div>
            </section>

            <section id="results-section">
                <div class="card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <i class="fas fa-list-alt header-icon"></i>
                        <span>نتائج اختبارات الشخصية</span>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table id="resultsTable" class="table table-hover display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>الهاتف</th>
                                        <th>الجنس</th>
                                        <th>النمط السائد</th>
                                        <th>A (%)</th>
                                        <th>B (%)</th>
                                        <th>C (%)</th>
                                        <th>D (%)</th>
                                        <th>تاريخ الاختبار</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Function to safely output data
                                    function safe_echo($value) {
                                        echo htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
                                    }

                                    // Loop through the fetched data
                                    foreach ($resultsData as $row) {
                                        // Get profile type label and class
                                        $profileLabel = '';
                                        $profileClass = '';
                                        $profileIcon = 'fas fa-question-circle'; // Default icon

                                        switch ($row['dominant_category']) {
                                            case 'A':
                                                $profileLabel = 'المنطقي التحليلي';
                                                $profileClass = 'profile-type-a';
                                                $profileIcon = 'fas fa-brain';
                                                break;
                                            case 'B':
                                                $profileLabel = 'المنظم التنفيذي';
                                                $profileClass = 'profile-type-b';
                                                $profileIcon = 'fas fa-tasks';
                                                break;
                                            case 'C':
                                                $profileLabel = 'العاطفي الاجتماعي';
                                                $profileClass = 'profile-type-c';
                                                $profileIcon = 'fas fa-heart';
                                                break;
                                            case 'D':
                                                $profileLabel = 'الابتكاري الاستراتيجي';
                                                $profileClass = 'profile-type-d';
                                                $profileIcon = 'fas fa-lightbulb';
                                                break;
                                        }

                                        // Format date
                                        $testDate = !empty($row['test_date']) ? date('Y-m-d H:i', strtotime($row['test_date'])) : 'N/A';

                                        // Format gender
                                        $gender = ($row['gender'] === 'male') ? 'ذكر' : (($row['gender'] === 'female') ? 'أنثى' : 'غير محدد');

                                        echo "<tr>";
                                        echo "<td>"; safe_echo($row['full_name']); echo "</td>";
                                        echo "<td>"; safe_echo($row['email']); echo "</td>"; 
                                        echo "<td>"; safe_echo($row['phone']); echo "</td>"; 
                                        echo "<td>"; safe_echo($gender); echo "</td>"; 
                                        echo "<td><div class='profile-type {$profileClass}'><i class='{$profileIcon} me-1'></i>{$profileLabel}</div></td>";
                                        echo "<td>"; safe_echo($row['score_a']); echo "</td>";
                                        echo "<td>"; safe_echo($row['score_b']); echo "</td>";
                                        echo "<td>"; safe_echo($row['score_c']); echo "</td>";
                                        echo "<td>"; safe_echo($row['score_d']); echo "</td>";
                                        echo "<td>{$testDate}</td>";
                                        echo "<td>
                                                <div class='action-buttons'>
                                                    <button class='btn-action btn-view view-details' data-id='{$row['id']}' title='عرض التفاصيل (قريباً)'>
                                                        <i class='fas fa-eye'></i>
                                                    </button>
                                                    <button class='btn-action btn-delete delete-result' data-id='{$row['id']}' data-name='".htmlspecialchars($row['full_name'] ?? 'المستخدم', ENT_QUOTES)."' title='حذف النتيجة'>
                                                        <i class='fas fa-trash'></i>
                                                    </button>
                                                </div>
                                              </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </div></main>

    <nav class="mobile-nav" id="mobileNav">
        <ul class="mobile-nav-menu">
            <li class="mobile-nav-item">
                <a href="#dashboard-section" class="mobile-nav-link active">
                    <i class="fas fa-chart-line mobile-nav-icon"></i>
                    <span class="mobile-nav-text">الإحصائيات</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="#results-section" class="mobile-nav-link">
                    <i class="fas fa-list-alt mobile-nav-icon"></i>
                    <span class="mobile-nav-text">النتائج</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="test.php" class="mobile-nav-link" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-vial mobile-nav-icon"></i>
                    <span class="mobile-nav-text">الاختبار</span>
                </a>
            </li>
            <li class="mobile-nav-item">
                <a href="?logout=true" class="mobile-nav-link">
                    <i class="fas fa-sign-out-alt mobile-nav-icon"></i>
                    <span class="mobile-nav-text">خروج</span>
                </a>
            </li>
        </ul>
    </nav>

    <button class="mobile-fab" id="refreshBtn" title="تحديث الصفحة">
        <i class="fas fa-sync-alt"></i>
    </button>
    <button class="mobile-fab" id="sidebarToggleBtn" title="تبديل القائمة الجانبية">
        <i class="fas fa-bars"></i>
    </button>

    <div class="overlay" id="overlay"></div>

    <form id="deleteForm" method="POST" action="dashboard.php" style="display: none;">
        <input type="hidden" name="delete_user" value="true">
        <input type="hidden" name="user_id" id="deleteUserId">
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js" integrity="sha512-X/YkDZyjTf4wyc2Vy16YGCPHwAY8rZJY+POgokZjQB2mhIRFJCckEGc6YyX9eNsPfn0PzThEuNs+uaomE5CO6A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script> <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.42.0/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            // --- Initializations ---

            // Initialize AOS (Animate on Scroll)
            AOS.init({
                duration: 600, // Slightly faster duration
                easing: 'ease-in-out-cubic', // Smoother easing
                once: true, // Animate only once
                mirror: false,
                offset: 50 // Trigger animation slightly earlier
            });

            // Initialize DataTables
            const resultsTable = $('#resultsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json', // Arabic translation
                    lengthMenu: "_MENU_ مدخلات", // Customize length menu text
                    search: "بحث:" // Customize search label
                },
                order: [[9, 'desc']], // Default sort by test date descending
                responsive: false, // Disable responsiveness to allow scrolling
                scrollX: true, // Enable horizontal scrolling
                scrollCollapse: true, // Enable scroll collapse
                pagingType: "simple_numbers", // Use simple pagination
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10', '25', '50', 'الكل'] // Simpler length menu text
                ],
                columnDefs: [
                    { targets: 10, orderable: false, searchable: false } // Only make actions column non-orderable/searchable
                ],
            });


            // Initialize ApexCharts
            const chartOptions = {
                series: [
                    parseInt($('#countAStat').text()) || 0,
                    parseInt($('#countBStat').text()) || 0,
                    parseInt($('#countCStat').text()) || 0,
                    parseInt($('#countDStat').text()) || 0
                ],
                labels: ['المنطقي التحليلي (A)', 'المنظم التنفيذي (B)', 'العاطفي الاجتماعي (C)', 'الابتكاري الاستراتيجي (D)'],
                chart: {
                    type: 'donut',
                    height: 350,
                    fontFamily: 'Tajawal, sans-serif',
                    animations: { enabled: true, easing: 'easeinout', speed: 800 },
                    toolbar: { show: true, tools: { download: true } } // Enable download tool
                },
                colors: ['#54c8e8', '#2ecc71', '#f39c12', '#e74c3c'], // Use root variables if possible
                fill: {
                    type: 'gradient',
                    gradient: { shade: 'light', type: "vertical", shadeIntensity: 0.2, opacityFrom: 0.85, opacityTo: 0.9, stops: [0, 100] }
                },
                stroke: { width: 2, colors: [ getComputedStyle(document.documentElement).getPropertyValue('--white').trim() || '#fff'] }, // Use CSS variable for stroke
                responsive: [{
                    breakpoint: 576, // Adjust breakpoint for smaller screens
                    options: {
                        chart: { height: 280 },
                        legend: { position: 'bottom', fontSize: '12px' }
                    }
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '60%', // Adjust donut size
                            labels: {
                                show: true,
                                name: { show: true, fontSize: '16px', fontWeight: 600 },
                                value: { show: true, fontSize: '20px', fontWeight: 700, formatter: (val) => val },
                                total: {
                                    show: true,
                                    label: 'الإجمالي',
                                    fontSize: '16px',
                                    fontWeight: 700,
                                    formatter: (w) => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                },
                legend: {
                    position: 'bottom', horizontalAlign: 'center', fontSize: '14px', fontWeight: 500,
                    markers: { width: 12, height: 12, radius: 6 },
                    itemMargin: { horizontal: 10, vertical: 8 }
                },
                tooltip: {
                    y: { formatter: (val) => val + " اختبار" },
                    theme: 'light' // Default theme, can be toggled
                },
                dataLabels: { enabled: false } // Keep labels off slices for cleaner look
            };

            const profileChart = new ApexCharts(document.querySelector("#profileChart"), chartOptions);
            profileChart.render();

            // --- Event Handlers ---

            // Smooth Scrolling for Nav Links
            $('a.nav-link[href^="#"], a.mobile-nav-link[href^="#"]').on('click', function(event) {
                const targetId = $(this).attr('href');
                const targetElement = $(targetId);

                if (targetElement.length) {
                    event.preventDefault();
                    const offsetTop = targetElement.offset().top - 20; // Adjust offset as needed

                    $('html, body').stop().animate({
                        scrollTop: offsetTop
                    }, 800, 'easeInOutQuad'); // Use jQuery easing if available

                    // Update active state immediately
                    updateActiveNav(targetId);

                    // Close mobile sidebar if open
                    if ($('#sidebar').hasClass('mobile-visible')) {
                        toggleMobileSidebar(false);
                    }
                }
            });

            // Update Active Nav Link on Scroll (using Intersection Observer for performance)
            const sections = $('section[id]');
            const navLinks = $('.nav-link, .mobile-nav-link');

            const observerOptions = {
                root: null, // relative to document viewport
                rootMargin: '-20% 0px -70% 0px', // Trigger when section is in the middle 10% of the viewport
                threshold: 0 // Trigger as soon as it enters/leaves the margin
            };

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const targetId = `#${entry.target.id}`;
                        updateActiveNav(targetId);
                    }
                });
            }, observerOptions);

            sections.each(function() {
                observer.observe(this);
            });

            function updateActiveNav(targetId) {
                navLinks.removeClass('active');
                $(`.nav-link[href="${targetId}"], .mobile-nav-link[href="${targetId}"]`).addClass('active');
            }


            // View Details Button (Placeholder)
            $(document).on('click', '.view-details', function() {
                // const userId = $(this).data('id'); // Get user ID if needed for future implementation
                Swal.fire({
                    title: 'عرض التفاصيل',
                    text: 'هذه الميزة قيد التطوير وسيتم إضافتها قريباً.',
                    icon: 'info',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: 'var(--primary)',
                    customClass: { container: 'swal-rtl' }
                });
            });

            // Delete Confirmation
            $(document).on('click', '.delete-result', function() {
                const userId = $(this).data('id');
                const userName = $(this).data('name');

                Swal.fire({
                    title: 'تأكيد الحذف',
                    html: `هل أنت متأكد من رغبتك في حذف نتائج اختبار <strong>"${userName}"</strong>؟<br><small class="text-danger mt-2 d-block">تحذير: لا يمكن التراجع عن هذا الإجراء!</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--danger)',
                    cancelButtonColor: 'var(--gray-600)',
                    confirmButtonText: 'نعم، حذف',
                    cancelButtonText: 'إلغاء',
                    customClass: { container: 'swal-rtl' },
                    showLoaderOnConfirm: true, // Show loader animation on confirm button
                    preConfirm: () => {
                        // Submit the hidden form for deletion
                        $('#deleteUserId').val(userId);
                        $('#deleteForm').submit();
                        // Return a promise that never resolves to keep the modal open
                        // until the page redirects.
                        return new Promise(() => {});
                    },
                    allowOutsideClick: () => !Swal.isLoading() // Prevent closing while loading
                });
            });

            // Sidebar Toggle Button (Mobile & Collapsed Desktop)
            const sidebar = $('#sidebar');
            const mainContent = $('#mainContent');
            const overlay = $('#overlay');
            const sidebarToggleButton = $('#sidebarToggleBtn');

            sidebarToggleButton.on('click', function() {
                 if ($(window).width() < 768) {
                    // Mobile behavior: Slide in/out
                    toggleMobileSidebar();
                } else {
                     // Desktop collapsed behavior: Expand/collapse width
                     sidebar.toggleClass('expanded');
                     mainContent.toggleClass('expanded');
                     // Update toggle button icon (optional)
                     $(this).find('i').toggleClass('fa-bars fa-times');
                 }
            });

            // Close mobile sidebar when clicking overlay
            overlay.on('click', function() {
                if (sidebar.hasClass('mobile-visible')) {
                     toggleMobileSidebar(false);
                }
            });

            function toggleMobileSidebar(forceState) {
                 const shouldBeVisible = forceState === undefined ? !sidebar.hasClass('mobile-visible') : forceState;
                 sidebar.toggleClass('mobile-visible', shouldBeVisible);
                 overlay.toggleClass('active', shouldBeVisible);
                 // Update toggle button icon
                 sidebarToggleButton.find('i').toggleClass('fa-bars', !shouldBeVisible).toggleClass('fa-times', shouldBeVisible);
            }


            // Mobile Refresh Button
            $('#refreshBtn').on('click', function() {
                const icon = $(this).find('i');
                icon.addClass('fa-spin'); // Add spin animation
                // Use location.reload() for a full refresh
                setTimeout(() => {
                    location.reload();
                    // No need to remove fa-spin as the page reloads
                }, 300); // Short delay for visual feedback
            });

            // Auto-hide Alerts
            $('.alert').delay(5000).fadeOut(500, function() {
                $(this).alert('close'); // Use Bootstrap's alert close method
            });

            // --- Enhancements ---

            // Add pulse animation to the highest stat value
            let maxVal = -1;
            let maxElement = null;
            $('.stat-value').each(function() {
                const val = parseInt($(this).text());
                if (!isNaN(val) && val > maxVal) {
                    maxVal = val;
                    maxElement = $(this);
                }
            });
            if (maxElement) {
                maxElement.closest('.stat-card').addClass('pulse'); // Pulse the whole card
            }

            // Handle window resize for responsive adjustments
            $(window).on('resize', function() {
                // Reinitialize DataTables scrolling on resize for better responsiveness
                resultsTable.columns.adjust().draw();
                
                // If window becomes larger than mobile breakpoint, ensure overlay is hidden
                if ($(window).width() > 767.98) {
                    if (overlay.hasClass('active')) {
                        toggleMobileSidebar(false); // Hide mobile sidebar and overlay
                    }
                } else {
                    // If window becomes smaller, ensure desktop expansion classes are removed
                    sidebar.removeClass('expanded');
                    mainContent.removeClass('expanded');
                }
            }).trigger('resize'); // Trigger resize on load to set initial state
        }); // End document ready
    </script>

</body>
</html>