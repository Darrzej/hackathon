<?php
session_start();
require_once "config.php";

// Check if the user is logged in and is a teacher or admin
if (!isset($_SESSION['id'])) {
    echo "<p>Access denied. Please log in.</p>";
    exit;
}

$userId = $_SESSION['id'];

// Get user details
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || ($user['isadmin'] !== 'true' && $user['isteacher'] !== 'true')) {
    echo "<p>Access denied. Only teachers and admins can access this page.</p>";
    exit;
}

$school = $user['school'];
$isAdmin = $user['isadmin'] === 'true';
$isTeacher = $user['isteacher'] === 'true';

// Handle grade update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'], $_POST['subject'], $_POST['grade'])) {
    $studentId = $_POST['student_id'];
    $subject = $_POST['subject'];
    $grade = (int)$_POST['grade'];

    // Update grade if record exists or insert if not
    $stmt = $conn->prepare("SELECT * FROM student_grades WHERE student_id = ? AND subject = ?");
    $stmt->execute([$studentId, $subject]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        $stmt = $conn->prepare("UPDATE student_grades SET grade = ? WHERE student_id = ? AND subject = ?");
        $stmt->execute([$grade, $studentId, $subject]);
    } else {
        $stmt = $conn->prepare("INSERT INTO student_grades (student_id, subject, grade, teacher_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$studentId, $subject, $grade, $userId]);
    }
    echo "<p style='color: green;'>Grade updated successfully!</p>";
}

// Get all students from the same school
$stmt = $conn->prepare("SELECT * FROM users WHERE isstudent = 'true' AND school = ?");
$stmt->execute([$school]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get all subjects
$subjects = ['Math', 'English', 'Albanian', 'Science', 'History', 'Geography', 'Physics', 'Chemistry', 'Biology', 'Art'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Grades - <?= htmlspecialchars($school) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5faff;
            color: #003366;
            padding: 20px;
        }
        h1 {
            color: #003366;
        }
        select, input[type='number'] {
            padding: 5px;
            margin: 5px;
        }
        .form-container {
            background: #ffffff;
            border: 2px solid #003366;
            padding: 15px;
            border-radius: 10px;
            width: fit-content;
        }
        input[type='submit'] {
            background-color: #003366;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type='submit']:hover {
            background-color: #0055a5;
        }
    </style>
</head>
<body>
    <h1>Edit Grades - <?= htmlspecialchars($school) ?></h1>
    <div class="form-container">
        <form method="POST" action="">
            <label for="student_id">Select Student:</label>
            <select name="student_id" required>
                <option value="" disabled selected>Choose a student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['id'] ?>">
                        <?= htmlspecialchars($student['name'] . ' ' . $student['surname']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="subject">Select Subject:</label>
            <select name="subject" required>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= $subject ?>"><?= $subject ?></option>
                <?php endforeach; ?>
            </select>

            <label for="grade">Grade (1 to 5):</label>
            <input type="number" name="grade" min="1" max="5" required>

            <input type="submit" value="Update Grade">
        </form>
    </div>
</body>
</html>
