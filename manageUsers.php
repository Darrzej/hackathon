<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: signin.php");
    exit();
}

$userId = $_SESSION['id'];
$stmt = $conn->prepare("SELECT isadmin FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['isadmin'] !== 'true') {
    echo "Access denied.";
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$deleteId]);
    header("Location: manageUsers.php");
    exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $school = $_POST['school'];
    $isstudent = $_POST['isstudent'] === 'null' ? null : 'true';
    $isteacher = $_POST['isteacher'] === 'null' ? null : 'true';
    $isadmin = $_POST['isadmin'] === 'null' ? null : 'true';

    $stmt = $conn->prepare("UPDATE users SET school = ?, isstudent = ?, isteacher = ?, isadmin = ? WHERE id = ?");
    $stmt->execute([$school, $isstudent, $isteacher, $isadmin, $id]);
    header("Location: manageUsers.php");
    exit();
}

// Filters
$filterRole = $_GET['role'] ?? '';
$filterSchool = $_GET['school'] ?? '';

$query = "SELECT id, name, surname, email, school, isstudent, isteacher, isadmin FROM users WHERE 1=1";
$params = [];

if ($filterRole === 'student') {
    $query .= " AND isstudent = 'true'";
} elseif ($filterRole === 'teacher') {
    $query .= " AND isteacher = 'true'";
} elseif ($filterRole === 'admin') {
    $query .= " AND isadmin = 'true'";
}

if (in_array($filterSchool, ['xhevdetdoda', 'samifrasheri', 'ahmetgashi', 'admin'])) {
    $query .= " AND school = ?";
    $params[] = $filterSchool;
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            margin: 40px;
        }
        h1 {
            color: #004aad;
        }
        .nav-btn {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #004aad;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #dddddd;
            text-align: center;
        }
        th {
            background-color: #004aad;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .btn {
            padding: 8px 12px;
            margin: 4px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: white;
        }
        .btn-edit {
            background-color: #fcbf1e;
        }
        .btn-delete {
            background-color: #e74c3c;
        }
        select, input[type="submit"] {
            padding: 6px;
        }
        input[type="submit"] {
            background-color: #004aad;
        }
        .filters {
            margin-bottom: 20px;
        }
        

    </style>
</head>
<body>

<a href="home.php" class="nav-btn">← Back to Home</a>

<h1>Manage Users</h1>

<div class="filters">
    <form method="GET" action="">
        <label>Filter by Role:
            <select name="role">
                <option value="">All</option>
                <option value="student" <?= $filterRole === 'student' ? 'selected' : '' ?>>Student</option>
                <option value="teacher" <?= $filterRole === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                <option value="admin" <?= $filterRole === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </label>
        <label>Filter by School:
            <select name="school">
                <option value="">All</option>
                <option value="xhevdetdoda" <?= $filterSchool === 'xhevdetdoda' ? 'selected' : '' ?>>Xhevdet Doda</option>
                <option value="samifrasheri" <?= $filterSchool === 'samifrasheri' ? 'selected' : '' ?>>Sami Frasheri</option>
                <option value="ahmetgashi" <?= $filterSchool === 'ahmetgashi' ? 'selected' : '' ?>>Ahmet Gashi</option>
                <option value="admin" <?= $filterSchool === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </label>
        <input type="submit" value="Apply Filters" class="btn" style="background-color: #004aad">
    </form>
</div>

<table>
    <tr>
        <th>Name</th>
        <th>Surname</th>
        <th>Email</th>
        <th>School</th>
        <th>isStudent</th>
        <th>isTeacher</th>
        <th>isAdmin</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $u): ?>
    <tr>
        <form method="POST">
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['surname']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td>
                <select name="school">
                    <option value="xhevdetdoda" <?= $u['school'] === 'xhevdetdoda' ? 'selected' : '' ?>>Xhevdet Doda</option>
                    <option value="samifrasheri" <?= $u['school'] === 'samifrasheri' ? 'selected' : '' ?>>Sami Frasheri</option>
                    <option value="ahmetgashi" <?= $u['school'] === 'ahmetgashi' ? 'selected' : '' ?>>Ahmet Gashi</option>
                    <option value="admin" <?= $u['school'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </td>
            <td>
                <select name="isstudent">
                    <option value="true" <?= $u['isstudent'] === 'true' ? 'selected' : '' ?>>true</option>
                    <option value="null" <?= $u['isstudent'] !== 'true' ? 'selected' : '' ?>>null</option>
                </select>
            </td>
            <td>
                <select name="isteacher">
                    <option value="true" <?= $u['isteacher'] === 'true' ? 'selected' : '' ?>>true</option>
                    <option value="null" <?= $u['isteacher'] !== 'true' ? 'selected' : '' ?>>null</option>
                </select>
            </td>
            <td>
                <select name="isadmin">
                    <option value="true" <?= $u['isadmin'] === 'true' ? 'selected' : '' ?>>true</option>
                    <option value="null" <?= $u['isadmin'] !== 'true' ? 'selected' : '' ?>>null</option>
                </select>
            </td>
            <td>
                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                <input type="submit" value="Save" class="btn btn-edit">
                <a href="manageUsers.php?delete=<?= $u['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </form>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
