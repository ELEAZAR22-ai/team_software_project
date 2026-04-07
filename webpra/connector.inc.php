<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $father = $_POST["father"];
    $mother = $_POST["mother"];
    $children = $_POST["children"];
    $location = $_POST["location"];
    $wealth = $_POST["wealth"];

    try {
        require_once " ";
        $query = "INSERT INTO nuecler (name, father, mother, children, wealth) VALUES (?, ?, ?, ?, ?);";

        $stmt->execute([$name, $father, $mother, $children, $wealth]);
        $pdo = null;
        $stmt = null;

        header("location: webpra/Nueclarfam.php");

        die();
    } catch (PDOException $d) {

        die("Query Failed: " . $d->getMessage());
    }
} else {
    header("location: ../Nueclarfam.php");
}
