<?php
session_start();
// Static Credentials (In a real app, use password_hash)
$admin_user = "admin";
$admin_pass = "blueYellow123";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === $admin_user && $pass === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: /review-system/review.php");
        exit;
    } else {
        $_SESSION['error'] = "Invalid Credentials!";
        header("Location: /review-system/admin.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comments'])) {
    $comments = $_POST['comments'];
    if (!empty($comments)) {
        try {
            require_once "dbho.php";
            $query = "INSERT INTO student_comments (comments) VALUES (?);";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$comments]);
            $pdo = null;
            $stmt = null;
            $_SESSION['success'] = "Comment posted successfully!";
            header("Location: /review-system/admin.php");
            exit;
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    } else {
        $_SESSION['error'] = "Comment cannot be empty!";
        header("Location: /review-system/admin.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record'])) {
    $lecturer_name = $_POST["lecturer_name"];
    $faculty = $_POST["faculty"];
    $arrival_time = $_POST["arrival_time"];
    $departure_time = $_POST["departure_time"];
    $num_courses = $_POST["num_courses"];
    $courses_covered = $_POST["courses_covered"];

    if (!empty($lecturer_name) && !empty($faculty) && !empty($arrival_time) && !empty($departure_time) && !empty($num_courses) && !empty($courses_covered)) {
        try {
            require_once "dbho.php";
            $query = "INSERT INTO record (lecturer_name, faculty, arrival_time, departure_time, num_courses, courses_covered) VALUES (?,?,?,?,?,?);";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$lecturer_name, $faculty, $arrival_time, $departure_time, $num_courses, $courses_covered]);
            $pdo = null;
            $stmt = null;
            $_SESSION['success'] = "Record sent successfully!";
            header("Location: /review-system/admin.php");
            exit;
        } catch (PDOException $e) {
            die("Input Failed: " . $e->getMessage());
        }
    } else {
        $_SESSION['error'] = "All Fields Must Be Filled!";
        header("Location: /review-system/review.php");
        exit;
    }
}
