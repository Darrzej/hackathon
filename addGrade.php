<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    echo "Access denied. Please log in.";
    exit();
}

$userId = $_SESSION['id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || (strtolower($user['school']) !== 'xhevdetdoda') || strtolower($user['isstudent']) === 'true') {
    echo "Access denied.";
    exit();
}

// Fetch all students from the same school
$studentsStmt = $conn->prepare("SELECT id, name, surname FROM users WHERE school = 'xhevdetdoda' AND isstudent = 'true'");
$studentsStmt->execute();
$students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch available subjects
$subjectsStmt = $conn->prepare("SELECT DISTINCT subject FROM student_grades WHERE subject IS NOT NULL");
$subjectsStmt->execute();
$subjects = $subjectsStmt->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $subject = $_POST['subject'];
    $grade = $_POST['grade'];
    $semester = $_POST['semester'];

    $insertStmt = $conn->prepare("INSERT INTO student_grades (student_id, subject, grade, semester, teacher_id) VALUES (?, ?, ?, ?, ?)");
    $insertStmt->execute([$studentId, $subject, $grade, $semester, $userId]);

    echo "<script>alert('Grade added successfully.'); window.location.href='xhevdetdoda.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Grade</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #003366;
            padding: 40px;
        }
        h2 {
            color: #003366;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        label, select, input {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
        input[type="submit"] {
            background-color: #ffc107;
            color: #003366;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Add Grade for Student</h2>
    <form method="POST">
        <label for="student_id">Select Student:</label>
        <select name="student_id" required>
            <?php foreach ($students as $student): ?>
                <option value="<?= $student['id'] ?>"><?= $student['name'] . ' ' . $student['surname'] ?></option>
            <?php endforeach; ?>
        </select>

        <label for="subject">Subject:</label>
        <select name="subject" required>
            <?php foreach ($subjects as $subj): ?>
                <option value="<?= $subj ?>"><?= $subj ?></option>
            <?php endforeach; ?>
        </select>

        <label for="grade">Grade (1-5):</label>
        <input type="number" name="grade" min="1" max="5" required>

        <label for="semester">Semester (1-4):</label>
        <input type="number" name="semester" min="1" max="4" required>

        <input type="submit" value="Add Grade">
    </form>
</body>
</html>
