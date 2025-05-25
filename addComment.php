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

if (!$user || (strtolower($user['school']) !== 'xhevdetdoda') || (strtolower($user['isteacher']) !== 'true' && strtolower($user['isadmin']) !== 'true')) {
    echo "Access denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment'] ?? '');

    if ($comment !== '') {
        $insert = $conn->prepare("INSERT INTO comments (user_id, comment) VALUES (?, ?)");
        $insert->execute([$userId, $comment]);
        header("Location: xhevdetdoda.php");
        exit();
    } else {
        $error = "Comment cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Comment</title>
    <style>
        body {
            background: linear-gradient(to bottom right, #e0f7ff, #ffffff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            color: #003366;
        }
        .container {
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        textarea {
            width: 100%;
            height: 120px;
            padding: 15px;
            font-size: 1rem;
            border-radius: 10px;
            border: 1px solid #ccc;
            resize: none;
        }
        input[type=submit] {
            margin-top: 20px;
            background-color: #0077cc;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #005fa3;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #0077cc;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Publish a Comment</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label for="comment">Your comment:</label><br>
        <textarea name="comment" id="comment" required></textarea><br>
        <input type="submit" value="Publish Comment">
    </form>
    <a class="back-link" href="xhevdetdoda.php">&larr; Back to Xhevdet Doda Page</a>
</div>
</body>
</html>
