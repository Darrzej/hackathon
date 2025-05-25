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

if (!$user || (strtolower($user['school']) !== 'ahmetgashi' && strtolower($user['isadmin']) !== 'true')) {
    echo "Access denied.";
    exit();
}

$isStudent = strtolower($user['isstudent']) === 'true';
$isTeacher = strtolower($user['isteacher']) === 'true';
$isAdmin = strtolower($user['isadmin']) === 'true';

$studentsStmt = $conn->prepare("SELECT id, name, surname FROM users WHERE school = 'ahmetgashi' AND isstudent = 'true'");
$studentsStmt->execute();
$students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

$subjectsStmt = $conn->prepare("SELECT DISTINCT subject FROM student_grades WHERE subject IS NOT NULL");
$subjectsStmt->execute();
$subjects = $subjectsStmt->fetchAll(PDO::FETCH_COLUMN);

$selectedStudent = $_GET['student_id'] ?? '';
$selectedSubject = $_GET['subject'] ?? '';
$selectedSemester = $_GET['semester'] ?? '';

$query = "SELECT g.*, u.name, u.surname FROM student_grades g JOIN users u ON g.student_id = u.id WHERE u.school = 'ahmetgashi'";
$params = [];

if ($isStudent) {
    $query .= " AND g.student_id = ?";
    $params[] = $userId;
} elseif ($selectedStudent) {
    $query .= " AND g.student_id = ?";
    $params[] = $selectedStudent;
}

if ($selectedSubject) {
    $query .= " AND g.subject = ?";
    $params[] = $selectedSubject;
}

if ($selectedSemester) {
    $query .= " AND g.semester = ?";
    $params[] = $selectedSemester;
}

$query .= " ORDER BY g.subject, g.semester";

$gradesStmt = $conn->prepare($query);
$gradesStmt->execute($params);
$grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);

$averageData = [];
foreach ($grades as $grade) {
    $subject = $grade['subject'];
    if (!isset($averageData[$subject])) {
        $averageData[$subject] = ['sum' => 0, 'count' => 0];
    }
    $averageData[$subject]['sum'] += $grade['grade'];
    $averageData[$subject]['count']++;
}
foreach ($averageData as $subject => $data) {
    $averageData[$subject] = round($data['sum'] / $data['count'], 2);
}

$commentsStmt = $conn->prepare("SELECT c.comment, c.timestamp, u.name, u.surname, CASE WHEN u.isadmin = 'true' THEN 'Admin' ELSE 'Teacher' END AS role FROM comments c JOIN users u ON c.user_id = u.id WHERE u.school = 'ahmetgashi' ORDER BY c.timestamp DESC");
$commentsStmt->execute();
$comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ahmet Gashi School</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #e0f7ff, #ffffff);
            color: #003366;
        }
        .navbar {
            background-color: #003366;
            padding: 20px 40px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }
        h2, h3 {
            color: #003366;
        }
        .button-bar {
            display: flex;
            gap: 20px;
            margin: 30px 0;
        }
        .button-bar a {
            background-color: #0077cc;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .button-bar a:hover {
            background-color: #005fa3;
        }
        .filters {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }
        select, input[type=submit] {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        input[type=submit] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #005fa3;
            color: white;
        }
        .school-history {
            background-color: #eef7ff;
            padding: 20px;
            border-left: 6px solid #0077cc;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        #gradeChart {
            margin-top: 50px;
        }
        .comments-section {
            margin-top: 60px;
        }
        .comment-card {
            background: #f5faff;
            border-left: 4px solid #0077cc;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .comment-meta {
            font-weight: bold;
            margin-bottom: 5px;
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
    <div class="navbar">
        <div><strong>Ahmet Gashi</strong></div>
        <div>
            <?php
                if ($isStudent) echo "Student: {$user['name']} {$user['surname']}";
                elseif ($isTeacher) echo "Teacher: {$user['name']} {$user['surname']}";
                elseif ($isAdmin) echo "Admin: {$user['name']} {$user['surname']}";
            ?>
        </div>
    </div>

    <div class="container">
        <a href="home.php" class="nav-btn">← Back</a>
        <h2>Welcome to Ahmet Gashi School</h2>
        <div class="school-history">
            <p><strong>Ahmet Gashi High School</strong>, located in a key residential area of Prishtina, is dedicated to the education and development of young minds. Named after a respected educator and intellectual, the school is committed to providing a strong foundation in core subjects while fostering creativity and community involvement. With modern facilities and passionate teachers, Ahmet Gashi School continues to play a vital role in shaping the next generation of Kosovar leaders and innovators. </p>
        </div>

        <div class="button-bar">
            <?php if ($isTeacher || $isAdmin): ?>
                <a href="ahmetgashi_addGrade.php">Add Grade</a>
                <a href="ahmetgashi_editGrades.php">Edit Grades</a>
                <a href="ahmetgashi_addComment.php">Add Comment</a>
            <?php endif; ?>
        </div>

        <form method="GET" class="filters">
            <?php if (!$isStudent): ?>
                <select name="student_id">
                    <option value="">All Students</option>
                    <?php foreach ($students as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= $selectedStudent == $s['id'] ? 'selected' : '' ?>><?= $s['name'] ?> <?= $s['surname'] ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <select name="subject">
                <option value="">All Subjects</option>
                <?php foreach ($subjects as $sub): ?>
                    <option value="<?= htmlspecialchars($sub) ?>" <?= $selectedSubject == $sub ? 'selected' : '' ?>><?= htmlspecialchars($sub) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="semester">
                <option value="">All Semesters</option>
                <option value="1" <?= $selectedSemester == '1' ? 'selected' : '' ?>>1</option>
                <option value="2" <?= $selectedSemester == '2' ? 'selected' : '' ?>>2</option>
                <option value="3" <?= $selectedSemester == '3' ? 'selected' : '' ?>>3</option>
                <option value="4" <?= $selectedSemester == '4' ? 'selected' : '' ?>>4</option>
            </select>
            <input type="submit" value="Filter">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Semester</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grades as $g): ?>
                    <tr>
                        <td><?= $g['name'] ?> <?= $g['surname'] ?></td>
                        <td><?= htmlspecialchars($g['subject']) ?></td>
                        <td><?= $g['grade'] ?></td>
                        <td><?= $g['semester'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <canvas id="gradeChart" width="800" height="400"></canvas>
        <script>
            const ctx = document.getElementById('gradeChart').getContext('2d');
            const chartData = {
                labels: <?= json_encode(array_keys($averageData)) ?>,
                datasets: [{
                    label: '<?= $isStudent ? "Your Average Grade" : "Average Grade Per Subject" ?>',
                    data: <?= json_encode(array_values($averageData)) ?>,
                    backgroundColor: '#0077cc',
                    borderRadius: 10
                }]
            };
            new Chart(ctx, {
                type: 'bar',
                data: chartData,
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

         <div class="comment-section" style="margin-top: 40px;">
  <h2 style="font-size: 24px; color: #333;">Comments</h2>
  <?php
  $stmt = $conn->prepare("SELECT * FROM comments WHERE school = 'ahmetgashi' ORDER BY created_at DESC");
  $stmt->execute();
  $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($comments && count($comments) > 0):
      foreach ($comments as $comment):
  ?>
      <div class="comment-card" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 8px; background-color: #f9f9f9;">
        <div class="comment-header" style="margin-bottom: 10px;">
          <strong style="color: #0056b3;"><?php echo htmlspecialchars($comment['name']); ?></strong>
          <span style="font-size: 14px; color: #555;">(<?php echo htmlspecialchars(ucfirst($comment['role'])); ?>)</span>
          <div style="font-size: 12px; color: #888;"><?php echo htmlspecialchars($comment['created_at']); ?></div>
        </div>
        <div class="comment-body" style="font-size: 16px; color: #333;">
          <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
        </div>
      </div>
  <?php
      endforeach;
  else:
      echo "<p style='color: #666;'>No comments yet. Be the first to share your thoughts.</p>";
  endif;
  ?>
</div>
    </div>
</body>
</html>
