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

if (!($isAdmin || ($isTeacher && $school === 'xhevdetdoda'))) {
    echo "Access denied.";
    exit();
}

$studentsStmt = $conn->prepare("SELECT id, name, surname FROM users WHERE school = 'xhevdetdoda' AND isstudent = 'true'");
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

    $teacherId = $userId;
    $insertStmt = $conn->prepare("INSERT INTO student_grades (student_id, subject, grade, semester, teacher_id) VALUES (?, ?, ?, ?, ?)");
    $insertStmt->execute([$studentId, $subject, $grade, $semester, $teacherId]);

    header("Location: addGrade.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <a href="xhevdetdoda.php" class="nav-btn">← Back</a>
    <title>Add Grade - Xhevdet Doda</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #003366;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        select, input[type="number"], button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #003366;
            color: white;
            border: none;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #0055aa;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
        }
        .nav-btn {
    display: inline-block;
    margin-bottom: 20px;
    background-color: #004aad; /* primary blue */
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.nav-btn:hover {
    background-color: #00337a; /* slightly darker blue on hover */
}

    </style>
</head>
<body>
<div class="container">
    <h2>Add Grade - Xhevdet Doda</h2>

    <?php if (isset($_GET['success'])): ?>
        <p class="success">Grade added successfully!</p>
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

        <button type="submit">Add Grade</button>
    </form>
</div>
</body>
</html>
