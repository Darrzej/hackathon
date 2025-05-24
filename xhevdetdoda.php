<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['id'])) {
    echo "Access denied. Please log in.";
    exit;
}

$user_id = $_SESSION['id'];

// Fetch user info
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || strtolower($user['school']) !== 'xhevdetdoda') {
    echo "Access denied. You are not part of Xhevdet Doda.";
    exit;
}

$isStudent = strtolower($user['isstudent']) === 'true';
$isTeacher = strtolower($user['isteacher']) === 'true';
$isAdmin   = strtolower($user['isadmin']) === 'true';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xhevdet Doda - Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f0f8ff;
        }
        nav {
            background-color: #003366;
            color: white;
            padding: 1em;
        }
        nav span {
            float: right;
        }
        .container {
            padding: 2em;
        }
        .card {
            background-color: white;
            border-left: 5px solid #003366;
            padding: 1em;
            margin-bottom: 2em;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 0.75em;
            text-align: center;
        }
        th {
            background-color: #e6f2ff;
        }
        .btn {
            background-color: #ffcc00;
            border: none;
            padding: 0.5em 1em;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav>
        <strong>Xhevdet Doda</strong>
        <span>
            <?php
            if ($isStudent) echo "Student: " . htmlspecialchars($user['name']);
            elseif ($isTeacher) echo "Teacher: " . htmlspecialchars($user['name']);
            elseif ($isAdmin) echo "Admin: " . htmlspecialchars($user['name']);
            ?>
        </span>
    </nav>

    <div class="container">
        <div class="card">
            <h2>History of Xhevdet Doda School</h2>
            <p>The Xhevdet Doda School is a historic educational institution in Prishtina, renowned for academic excellence and student empowerment. Founded decades ago, it continues to play a vital role in shaping the minds of future leaders.</p>
        </div>

        <div class="card">
            <h2>Student Grades</h2>
            <table>
                <tr>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Schedule</th>
                    <?php if ($isTeacher || $isAdmin) echo "<th>Action</th>"; ?>
                </tr>
                <?php
                if ($isStudent) {
                    $stmt = $conn->prepare("SELECT * FROM student_grades WHERE student_id = ?");
                    $stmt->execute([$user_id]);
                } else {
                    $stmt = $conn->prepare("SELECT sg.*, u.name FROM student_grades sg JOIN users u ON sg.student_id = u.id WHERE u.school = 'xhevdetdoda'");
                    $stmt->execute();
                }

                $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $subjectTotals = [];
                $subjectCounts = [];

                foreach ($grades as $grade) {
                    $studentName = isset($grade['name']) ? $grade['name'] : $user['name'];
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($studentName) . "</td>";
                    echo "<td>" . htmlspecialchars($grade['subject']) . "</td>";

                    if ($isTeacher || $isAdmin) {
                        echo "<td><form method='POST'><input type='hidden' name='grade_id' value='" . $grade['id'] . "'>";
                        echo "<input type='number' name='new_grade' min='1' max='5' value='" . $grade['grade'] . "' required>";
                        echo "</td><td>" . htmlspecialchars($grade['schedule']) . "</td>";
                        echo "<td><button class='btn' type='submit'>Update</button></form></td>";
                    } else {
                        echo "<td>" . $grade['grade'] . "</td>";
                        echo "<td>" . htmlspecialchars($grade['schedule']) . "</td>";
                    }

                    $subject = $grade['subject'];
                    if (!isset($subjectTotals[$subject])) {
                        $subjectTotals[$subject] = 0;
                        $subjectCounts[$subject] = 0;
                    }
                    $subjectTotals[$subject] += $grade['grade'];
                    $subjectCounts[$subject]++;

                    echo "</tr>";
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($isTeacher || $isAdmin)) {
                    $gradeId = $_POST['grade_id'];
                    $newGrade = $_POST['new_grade'];
                    $update = $conn->prepare("UPDATE student_grades SET grade = ? WHERE id = ?");
                    $update->execute([$newGrade, $gradeId]);
                    echo "<script>location.reload();</script>";
                }
                ?>
            </table>
        </div>

        <div class="card">
            <h2>Grade Statistics</h2>
            <canvas id="gradeChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('gradeChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($subjectTotals)); ?>,
                datasets: [{
                    label: 'Average Grade',
                    backgroundColor: '#003366',
                    borderColor: '#003366',
                    data: <?php echo json_encode(array_map(function($subject) use ($subjectTotals, $subjectCounts) {
                        return round($subjectTotals[$subject] / $subjectCounts[$subject], 2);
                    }, array_keys($subjectTotals))); ?>
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
        });
    </script>
</body>
</html>