<?php
header('Content-Type: application/json');
require_once "dbho.php";

if (!isset($pdo) || $pdo === null) {
    throw new PDOException("Database connection failed");
}

try {
    // Ranking Logic: (courses_covered / num_courses) * 100
    // We limit to 3 to get the "Top 3"
    $query = "SELECT lecturer_name, 
              (SUM(courses_covered) / SUM(num_courses) * 100) as performance_score 
              FROM record 
              GROUP BY lecturer_name 
              ORDER BY performance_score DESC 
              LIMIT 3";

    $stmt = $pdo->query($query);
    if ($stmt === false) {
        throw new PDOException("Query failed");
    }
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
