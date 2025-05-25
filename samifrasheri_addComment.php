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

if (!($isAdmin || ($isTeacher && $school === 'samifrasheri'))) {
    echo "Access denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $authorId = $userId;
    $schoolName = 'samifrasheri';

    $insertStmt = $conn->prepare("INSERT INTO comments (comment, author_id, school_name) VALUES (?, ?, ?)");
    $insertStmt->execute([$comment, $authorId, $schoolName]);

    header("Location: samifrasheri_addComment.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
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
