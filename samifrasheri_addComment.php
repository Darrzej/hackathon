<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    echo "Access denied. Please log in.";
    exit();
}

$userId = $_SESSION['id'];


$stmt = $conn->prepare("SELECT name, surname, isstudent, isteacher, isadmin, school FROM users WHERE id = ?");
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


if (!($isAdmin || ($isTeacher && $school === 'samifrasheri'))) {
    echo "Access denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);

    if (empty($comment)) {
        echo "Comment cannot be empty.";
        exit();
    }

    $fullName = $user['name'] . ' ' . $user['surname'];
    $role = $isAdmin ? 'admin' : 'teacher';
    $schoolName = 'samifrasheri';

    $insertStmt = $conn->prepare("INSERT INTO comments (user_id, role, name, comment, school, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $insertStmt->execute([$userId, $role, $fullName, $comment, $schoolName]);

    header("Location: samifrasheri.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <a href="samifrasheri.php" class="nav-btn">← Back</a>
    <title>Add Comment - Sami Frasheri</title>
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
        textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        textarea {
            height: 120px;
            resize: vertical;
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
    <h2>Add Comment - Sami Frasheri</h2>

    <?php if (isset($_GET['success'])): ?>
        <p class="success">Comment added successfully!</p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="comment">Comment:</label>
        <textarea name="comment" required></textarea>
        <button type="submit">Publish Comment</button>
    </form>
</div>
</body>
</html>
