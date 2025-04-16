<?php
require_once 'config.php';

header('Content-Type: application/json');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from request
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Invalid data format']);
        exit;
    }
    
    // Extract user data
    $fullName = $conn->real_escape_string($data['personalInfo']['name']);
    $phone = $conn->real_escape_string($data['personalInfo']['phone']);
    $email = $conn->real_escape_string($data['personalInfo']['email']);
    $gender = $conn->real_escape_string($data['personalInfo']['gender']);
    
    // Extract test results
    $scoreA = intval($data['results']['A']);
    $scoreB = intval($data['results']['B']);
    $scoreC = intval($data['results']['C']);
    $scoreD = intval($data['results']['D']);
    $dominantCategory = $conn->real_escape_string($data['dominantCategory']);
    $selections = json_encode($data['selections'], JSON_UNESCAPED_UNICODE);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Insert user data
        $userSql = "INSERT INTO users (full_name, phone, email, gender) 
                   VALUES ('$fullName', '$phone', '$email', '$gender')";
        
        if (!$conn->query($userSql)) {
            throw new Exception('Error inserting user data: ' . $conn->error);
        }
        
        $userId = $conn->insert_id;
        
        // Insert test results
        $resultSql = "INSERT INTO test_results (user_id, score_a, score_b, score_c, score_d, dominant_category, selections) 
                     VALUES ($userId, $scoreA, $scoreB, $scoreC, $scoreD, '$dominantCategory', '$selections')";
        
        if (!$conn->query($resultSql)) {
            throw new Exception('Error inserting test results: ' . $conn->error);
        }
        
        // Commit transaction
        $conn->commit();
        
        echo json_encode(['success' => true, 'message' => 'تم حفظ النتائج بنجاح']);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>