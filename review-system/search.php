<?php
header('Content-Type: application/json');
require_once "dbho.php";

$name = $_GET['name'] ?? '';

try {
    if ($pdo === null) {
        throw new PDOException("Database connection failed");
    }
    
    // Search for any lecturer matching the name
    $query = "SELECT lecturer_name, (courses_covered / num_courses * 100) as performance_score 
              FROM record 
              WHERE lecturer_name LIKE ? 
              LIMIT 5";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(["%$name%"]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode([]);
}