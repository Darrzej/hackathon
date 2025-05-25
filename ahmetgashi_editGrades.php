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

if (!$user) {
    echo "Access denied.";
    exit();
}

$school = strtolower($user['school']);
$isStudent = strtolower($user['isstudent']) === 'true';
$isTeacher = strtolower($user['isteacher']) === 'true';
$isAdmin = strtolower($user['isadmin']) === 'true';

if (!($isAdmin || ($isTeacher && $school === 'ahmetgashi'))) {
    echo "Access denied.";
    exit();
}

$studentsStmt = $conn->prepare("SELECT id, name, surname FROM users WHERE school = 'ahmetgashi' AND isstudent = 'true'");
$studentsStmt->execute();
$students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

$subjectsStmt = $conn->prepare("SELECT DISTINCT subject FROM student_grades WHERE subject IS NOT NULL");
$subjectsStmt->execute();
$subjects = $subjectsStmt->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $subject = $_POST['subject'];
    $grade = $_POST['grade'];
    $semester = $_POST['semester'];

    $updateStmt = $conn->prepare("UPDATE student_grades SET grade = ? WHERE student_id = ? AND subject = ? AND semester = ?");
    $updateStmt->execute([$grade, $studentId, $subject, $semester]);

    header("Location: ahmetgashi_editGrades.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Grades - Ahmet Gashi</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #004085;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            margin-bottom: 5px;
        }
        select, input[type=number] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #004085;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #002752;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Grades - Ahmet Gashi</h2>

        <?php if (isset($_GET['success'])): ?>
            <p class="success">Grade updated successfully!</p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="student_id">Student:</label>
            <select name="student_id" required>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['id'] ?>">
                        <?= htmlspecialchars($student['name'] . ' ' . $student['surname']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="subject">Subject:</label>
            <select name="subject" required>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= htmlspecialchars($subject) ?>">
                        <?= htmlspecialchars($subject) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="semester">Semester:</label>
            <select name="semester" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <label for="grade">Grade:</label>
            <input type="number" name="grade" min="1" max="5" required>

            <button type="submit">Update Grade</button>
        </form>
    </div>
</body>
</html>
