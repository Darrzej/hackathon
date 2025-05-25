<?php

session_start();

include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($password)) {
        echo "Please fill in all fields";
    } else {
        $sql = "SELECT id, name, surname, email, password, isadmin, isstudent, school, isteacher FROM users WHERE name = :name";
        $selectUser = $conn->prepare($sql);
        $selectUser->bindParam(":name", $name);
        $selectUser->execute();
        $data = $selectUser->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            echo "The user does not exist";
        } else {
            if (password_verify($password, $data['password'])) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['name'] = $data['name'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['surname'] = $data['surname'];
                $_SESSION['isstudent'] = $data['isstudent'];
                $_SESSION['isadmin'] = $data['isadmin'];
                $_SESSION['school'] = $data['school'];
                $_SESSION['isteacher'] = $data['isteacher'];

                
                header('Location: home.php');
                exit(); 
            } else {
                echo "The password is not valid";
            }
        }
    }
}
?>
