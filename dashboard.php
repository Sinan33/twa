<?php
// Start session
session_start();

// Handle login from form submission
if (isset($_POST['auth']) && $_POST['auth'] === 'true') {
    $_SESSION['admin_logged_in'] = true;
}

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin.php');
    exit;
}

// Handle logout
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset();
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Include database connection
require_once 'config.php';

// Get test results with user information
$sql = "SELECT u.id, u.full_name, u.email, u.phone, u.gender, u.test_date, 
               r.score_a, r.score_b, r.score_c, r.score_d, r.dominant_category
        FROM users u
        JOIN test_results r ON u.id = r.user_id
        ORDER BY u.test_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم اختبار توازن</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    
    <style>
        :root {
            --primary: #54c8e8;
            --primary-dark: #083347;
            --primary-light: rgba(84, 200, 232, 0.153);
            --secondary: #8ad7ed;
            --white: #ffffff;
            --dark: #083347;
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
            --info: #54c8e8;
            --font-main: 'Tajawal', sans-serif;
            --shadow: 0 4px 6px rgba(8, 51, 71, 0.1);
            --shadow-md: 0 10px 15px -3px rgba(8, 51, 71, 0.1), 0 4px 6px -2px rgba(8, 51, 71, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(8, 51, 71, 0.1), 0 10px 10px -5px rgba(8, 51, 71, 0.04);
            --radius: 0.5rem;
            --radius-lg: 1rem;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-main);
        }

        html, body {
            height: 100%;
            direction: rtl;
        }

        body {
            background-color: #f6f9fc;
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Layout */
        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, var(--primary-dark) 0%, #051a24 100%);
            color: var(--white);
            padding: 1.5rem 0;
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            overflow-y: auto;
            z-index: 10;
            box-shadow: -4px 0 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .sidebar-header {
            padding: 0 1.5rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        }

        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .sidebar-subtitle {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .nav-menu {
            list-style: none;
            padding: 0 1rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--white);
            text-decoration: none;
            border-radius: var(--radius);
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-icon {
            width: 1.25rem;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 2rem;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: rgba(231, 76, 60, 0.15);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
            justify-content: center;
        }

        .logout-btn:hover {
            background-color: rgba(231, 76, 60, 0.3);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            margin-right: 250px;
            transition: var(--transition);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background-color: var(--white);
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
        }

        .card {
            background-color: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 2rem;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            font-weight: 700;
            font-size: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Dashboard Stats */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .stat-icon-blue {
            background-color: rgba(84, 200, 232, 0.15);
            color: var(--primary);
        }

        .stat-icon-green {
            background-color: rgba(46, 204, 113, 0.15);
            color: var(--success);
        }

        .stat-icon-orange {
            background-color: rgba(243, 156, 18, 0.15);
            color: var(--warning);
        }

        .stat-icon-red {
            background-color: rgba(231, 76, 60, 0.15);
            color: var(--danger);
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            line-height: 1.2;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Table */
        .table-container {
            border-radius: var(--radius);
            overflow: hidden;
            background-color: var(--white);
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        table.dataTable thead th {
            background-color: #f8f9fa;
            color: var(--text-primary);
            font-weight: 600;
            border-bottom: 2px solid var(--border);
            padding: 1rem;
            text-align: right;
        }

        table.dataTable tbody td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        table.dataTable tbody tr:last-child td {
            border-bottom: none;
        }

        table.dataTable tbody tr:hover {
            background-color: rgba(84, 200, 232, 0.05);
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            padding: 1rem;
            color: var(--text-secondary);
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0.5rem;
            margin-right: 0.5rem;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 0.5rem;
            margin: 0 0.25rem;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 50rem;
        }

        .badge-blue {
            background-color: var(--primary);
        }

        .badge-green {
            background-color: var(--success);
        }

        .badge-orange {
            background-color: var(--warning);
        }

        .badge-red {
            background-color: var(--danger);
        }

        /* Profile Type */
        .profile-type {
            padding: 0.35rem 0.65rem;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .profile-type-a {
            background-color: rgba(84, 200, 232, 0.15);
            color: var(--primary);
        }

        .profile-type-b {
            background-color: rgba(46, 204, 113, 0.15);
            color: var(--success);
        }

        .profile-type-c {
            background-color: rgba(243, 156, 18, 0.15);
            color: var(--warning);
        }

        .profile-type-d {
            background-color: rgba(231, 76, 60, 0.15);
            color: var(--danger);
        }

        /* Charts */
        .chart-container {
            height: 300px;
            margin-top: 1rem;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar {
                width: 70px;
                padding: 1rem 0;
            }
            
            .sidebar-header {
                padding: 0 0.5rem 1rem;
            }
            
            .sidebar-title,
            .sidebar-subtitle,
            .nav-text,
            .logout-text {
                display: none;
            }
            
            .nav-link {
                padding: 0.75rem;
                justify-content: center;
            }
            
            .sidebar-footer {
                padding: 1rem 0.5rem;
            }
            
            .logout-btn {
                padding: 0.75rem;
            }
            
            .main-content {
                margin-right: 70px;
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .header {
                padding: 1rem;
                margin-bottom: 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .card-header {
                padding: 1rem;
            }
            
            .card-body {
                padding: 1rem;
            }
        }

        /* Utilities */
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }
        .mt-5 { margin-top: 3rem; }

        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mb-5 { margin-bottom: 3rem; }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="https://rayansu.com/3/wp-content/uploads/2021/05/new-logo.png" alt="Logo" class="sidebar-logo">
                <h1 class="sidebar-title">لوحة التحكم</h1>
                <div class="sidebar-subtitle">اختبار توازن للشخصية</div>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <span class="nav-text">الإحصائيات</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#results" class="nav-link">
                        <i class="fas fa-list-alt nav-icon"></i>
                        <span class="nav-text">نتائج الاختبارات</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="test.php" class="nav-link" target="_blank">
                        <i class="fas fa-external-link-alt nav-icon"></i>
                        <span class="nav-text">صفحة الاختبار</span>
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <a href="?logout=true" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="logout-text">تسجيل الخروج</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="header-title">لوحة تحكم اختبار توازن للشخصية</h1>
                <div class="date"><?php echo date('Y-m-d') ?></div>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-container fade-in">
                <?php
                // Count total tests
                $totalTests = $result->num_rows;
                
                // Count by dominant category
                $countA = 0;
                $countB = 0;
                $countC = 0;
                $countD = 0;
                
                // Clone result to count by category
                $resultCopy = $result;
                while ($row = $resultCopy->fetch_assoc()) {
                    switch ($row['dominant_category']) {
                        case 'A': $countA++; break;
                        case 'B': $countB++; break;
                        case 'C': $countC++; break;
                        case 'D': $countD++; break;
                    }
                }
                
                // Reset pointer to beginning
                $result->data_seek(0);
                ?>
                
                <div class="stat-card">
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $totalTests; ?></div>
                        <div class="stat-label">إجمالي الاختبارات</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $countA; ?></div>
                        <div class="stat-label">المنطقي التحليلي</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon stat-icon-green">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $countB; ?></div>
                        <div class="stat-label">المنظم التنفيذي</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon stat-icon-orange">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $countC; ?></div>
                        <div class="stat-label">العاطفي الاجتماعي</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon stat-icon-red">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value"><?php echo $countD; ?></div>
                        <div class="stat-label">الابتكاري الاستراتيجي</div>
                    </div>
                </div>
            </div>
            
            <!-- Chart -->
            <div class="card fade-in">
                <div class="card-header">
                    <i class="fas fa-chart-pie mr-2"></i>
                    توزيع أنماط الشخصية
                </div>
                <div class="card-body">
                    <div id="profileChart" class="chart-container"></div>
                </div>
            </div>
            
            <!-- Test Results -->
            <div class="card fade-in" id="results">
                <div class="card-header">
                    <i class="fas fa-list-alt mr-2"></i>
                    نتائج اختبارات الشخصية
                </div>
                <div class="card-body">
                    <div class="table-container">
                        <table id="resultsTable" class="display" style="width:100%">
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
                                    <th>تفاصيل</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    // Get profile type label and class
                                    $profileLabel = '';
                                    $profileClass = '';
                                    
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
                                    $testDate = date('Y-m-d H:i', strtotime($row['test_date']));
                                    
                                    // Format gender
                                    $gender = $row['gender'] === 'male' ? 'ذكر' : 'أنثى';
                                    
                                    echo "
                                    <tr>
                                        <td>{$row['full_name']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['phone']}</td>
                                        <td>{$gender}</td>
                                        <td>
                                            <div class='profile-type {$profileClass}'>
                                                <i class='{$profileIcon}'></i>
                                                {$profileLabel}
                                            </div>
                                        </td>
                                        <td>{$row['score_a']}</td>
                                        <td>{$row['score_b']}</td>
                                        <td>{$row['score_c']}</td>
                                        <td>{$row['score_d']}</td>
                                        <td>{$testDate}</td>
                                        <td>
                                            <button class='view-details' data-id='{$row['id']}'>
                                                <i class='fas fa-eye'></i>
                                            </button>
                                        </td>
                                    </tr>
                                    ";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#resultsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json',
                },
                order: [[9, 'desc']], // Order by test date descending
                responsive: true,
                columnDefs: [
                    { targets: 10, orderable: false } // No sorting for details button
                ]
            });
            
            // Initialize Charts
            const profileChart = new ApexCharts(document.querySelector("#profileChart"), {
                series: [
                    <?php echo $countA; ?>, 
                    <?php echo $countB; ?>, 
                    <?php echo $countC; ?>, 
                    <?php echo $countD; ?>
                ],
                labels: ['المنطقي التحليلي', 'المنظم التنفيذي', 'العاطفي الاجتماعي', 'الابتكاري الاستراتيجي'],
                chart: {
                    type: 'donut',
                    height: 300
                },
                colors: ['#54c8e8', '#2ecc71', '#f39c12', '#e74c3c'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '50%'
                        }
                    }
                },
                legend: {
                    position: 'bottom'
                }
            });
            
            profileChart.render();
            
            // Smooth scroll for navigation
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if(target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 20
                    }, 800);
                }
            });
            
            // Handle nav link active state
            $('.nav-link').on('click', function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });
            
            // Animate stats on scroll
            $(window).on('scroll', function() {
                $('.fade-in').each(function() {
                    var elementTop = $(this).offset().top;
                    var elementHeight = $(this).height();
                    var windowHeight = $(window).height();
                    var scrollY = $(window).scrollTop();
                    
                    if (elementTop < (scrollY + windowHeight) && (elementTop + elementHeight) > scrollY) {
                        $(this).css('opacity', '1');
                        $(this).css('transform', 'translateY(0)');
                    }
                });
            }).scroll();
            
            // View details button click handler
            $(document).on('click', '.view-details', function() {
                const userId = $(this).data('id');
                alert('سيتم إضافة تفاصيل المستخدم رقم: ' + userId + ' في التحديث القادم');
            });
        });
    </script>
</body>
</html>