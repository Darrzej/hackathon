<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    die("Access denied. Please log in.");
}

$userId = $_SESSION['id'];

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || strtolower($user['school']) !== 'xhevdetdoda') {
    die("Access denied. This page is restricted to users from Xhevdet Doda.");
}

$isStudent = strtolower($user['isstudent']) === 'true';
$isTeacher = strtolower($user['isteacher']) === 'true';
$isAdmin = strtolower($user['isadmin']) === 'true';

// Handle dropdown selection
$selectedStudentId = null;
if (($isTeacher || $isAdmin) && isset($_GET['student_id'])) {
    $selectedStudentId = $_GET['student_id'];
}

// Fetch students from this school
$studentsStmt = $conn->prepare("SELECT id, name, surname FROM users WHERE school = 'xhevdetdoda' AND isstudent = 'true'");
$studentsStmt->execute();
$students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch grades
if ($isStudent) {
    $gradesStmt = $conn->prepare("SELECT subject, grade FROM student_grades WHERE student_id = ?");
    $gradesStmt->execute([$userId]);
} elseif ($isTeacher || $isAdmin) {
    if ($selectedStudentId) {
        $gradesStmt = $conn->prepare("SELECT u.name, u.surname, g.subject, g.grade FROM student_grades g JOIN users u ON g.student_id = u.id WHERE g.student_id = ?");
        $gradesStmt->execute([$selectedStudentId]);
    } else {
        $gradesStmt = $conn->prepare("SELECT u.name, u.surname, g.subject, g.grade FROM student_grades g JOIN users u ON g.student_id = u.id WHERE u.school = 'xhevdetdoda'");
        $gradesStmt->execute();
    }
}
$grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);

// Organize grades for chart
$subjectAverages = [];
$subjectCounts = [];
foreach ($grades as $grade) {
    $subject = $grade['subject'];
    $value = $grade['grade'];

    if (!isset($subjectAverages[$subject])) {
        $subjectAverages[$subject] = 0;
        $subjectCounts[$subject] = 0;
    }
    $subjectAverages[$subject] += $value;
    $subjectCounts[$subject]++;
}
foreach ($subjectAverages as $subject => $total) {
    $subjectAverages[$subject] = round($total / $subjectCounts[$subject], 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xhevdet Doda School</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            margin: 0;
            padding: 0;
        }
        nav {
            background: #003366;
            color: white;
            padding: 15px;
            font-size: 20px;
        }
        .container {
            padding: 20px;
        }
        h2 {
            color: #003366;
        }
        .history {
            background: #e6f0ff;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 5px solid #003366;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        table, th, td {
            border: 1px solid #999;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #003366;
            color: white;
        }
        .dropdown-container {
            margin-top: 20px;
        }
        .dropdown-container select {
            padding: 8px;
            font-size: 16px;
        }
        .chart-container {
            margin-top: 40px;
            background: #fffbe6;
            padding: 20px;
            border: 2px solid #ffcc00;
        }
        .edit-btn {
            display: inline-block;
            background: #003366;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            margin-top: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <nav>
        Xhevdet Doda - 
        <?php
        if ($isStudent) {
            echo "Student: " . htmlspecialchars($user['name']);
        } elseif ($isTeacher) {
            echo "Teacher: " . htmlspecialchars($user['name']);
        } elseif ($isAdmin) {
            echo "Admin: " . htmlspecialchars($user['name']);
        }
        ?>
    </nav>

    <div class="container">
        <div class="history">
            <h2>About Xhevdet Doda School</h2>
            <p>Xhevdet Doda is a leading educational institution in Prishtina, focused on excellence and academic growth. It has a strong reputation in sciences, arts, and student leadership.</p>
        </div>

        <?php if ($isTeacher || $isAdmin): ?>
            <div class="dropdown-container">
                <form method="GET" action="">
                    <label for="student_id">Filter by student:</label>
                    <select name="student_id" id="student_id" onchange="this.form.submit()">
                        <option value="">All students</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['id'] ?>" <?= $selectedStudentId == $student['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($student['name'] . ' ' . $student['surname']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        <?php endif; ?>

        <h2>Grades Table</h2>
        <table>
            <tr>
                <?php if (!$isStudent): ?>
                    <th>Name</th>
                    <th>Surname</th>
                <?php endif; ?>
                <th>Subject</th>
                <th>Grade</th>
            </tr>
            <?php foreach ($grades as $grade): ?>
                <tr>
                    <?php if (!$isStudent): ?>
                        <td><?= htmlspecialchars($grade['name']) ?></td>
                        <td><?= htmlspecialchars($grade['surname']) ?></td>
                    <?php endif; ?>
                    <td><?= htmlspecialchars($grade['subject']) ?></td>
                    <td><?= htmlspecialchars($grade['grade']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="chart-container">
            <h2>Grade Statistics</h2>
            <canvas id="gradesChart"></canvas>
        </div>

        <?php if ($isTeacher || $isAdmin): ?>
            <a href="editGrades.php" class="edit-btn">Edit Grades</a>
        <?php endif; ?>
    </div>

    <script>
        const ctx = document.getElementById('gradesChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_keys($subjectAverages)) ?>,
                datasets: [{
                    label: 'Average Grade',
                    data: <?= json_encode(array_values($subjectAverages)) ?>,
                    backgroundColor: 'rgba(0, 102, 204, 0.7)',
                    borderColor: 'rgba(0, 102, 204, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        min: 1,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
