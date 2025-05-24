<?php

$host = "localhost";
$db = "eduprishtina";
$user = "root";
$pass = "";

try{
    $conn = new PDO("mysql:host=$host; dbname=$db", $user, $pass);


}

catch(exception $e){
    echo "Error: ";
}


?>