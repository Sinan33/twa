<?php
// Habilitar reportes de errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión a la base de datos
require_once 'config.php';

// Configurar cabeceras para respuesta JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Registrar datos recibidos para depuración
$raw_data = file_get_contents('php://input');
error_log('Datos raw recibidos: ' . $raw_data);

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos JSON de la solicitud
    $data = json_decode($raw_data, true);
    
    if (!$data) {
        error_log('Error decodificando JSON: ' . json_last_error_msg());
        echo json_encode(['success' => false, 'message' => 'Invalid data format: ' . json_last_error_msg()]);
        exit;
    }
    
    error_log('Datos decodificados: ' . print_r($data, true));
    
    // Verificar que todos los campos requeridos existen
    if (!isset($data['personalInfo']) || !isset($data['results']) || !isset($data['dominantCategory'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }
    
    // Extraer datos del usuario
    $fullName = $conn->real_escape_string($data['personalInfo']['name']);
    $phone = $conn->real_escape_string($data['personalInfo']['phone']);
    $email = $conn->real_escape_string($data['personalInfo']['email']);
    $gender = $conn->real_escape_string($data['personalInfo']['gender']);
    
    // Extraer resultados del test
    $scoreA = intval($data['results']['A']);
    $scoreB = intval($data['results']['B']);
    $scoreC = intval($data['results']['C']);
    $scoreD = intval($data['results']['D']);
    $dominantCategory = $conn->real_escape_string($data['dominantCategory']);
    $selections = json_encode($data['selections'], JSON_UNESCAPED_UNICODE);
    
    // Registrar valores para depuración
    error_log("Usuario: $fullName, Teléfono: $phone, Email: $email, Género: $gender");
    error_log("Puntajes: A=$scoreA, B=$scoreB, C=$scoreC, D=$scoreD, Dominante: $dominantCategory");
    
    // Iniciar transacción
    $conn->begin_transaction();
    
    try {
        // Insertar datos del usuario
        $userSql = "INSERT INTO users (full_name, phone, email, gender) 
                   VALUES ('$fullName', '$phone', '$email', '$gender')";
        
        if (!$conn->query($userSql)) {
            throw new Exception('Error insertando datos del usuario: ' . $conn->error);
        }
        
        $userId = $conn->insert_id;
        error_log("Usuario insertado con ID: $userId");
        
        // Insertar resultados del test
        $resultSql = "INSERT INTO test_results (user_id, score_a, score_b, score_c, score_d, dominant_category, selections) 
                     VALUES ($userId, $scoreA, $scoreB, $scoreC, $scoreD, '$dominantCategory', '$selections')";
        
        if (!$conn->query($resultSql)) {
            throw new Exception('Error insertando resultados del test: ' . $conn->error);
        }
        
        error_log("Resultados del test insertados correctamente");
        
        // Confirmar transacción
        $conn->commit();
        
        echo json_encode(['success' => true, 'message' => 'تم حفظ النتائج بنجاح', 'user_id' => $userId]);
        
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conn->rollback();
        error_log('Excepción: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method. Only POST is allowed.']);
}
?>