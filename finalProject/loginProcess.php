<?php
session_start();

include 'dbConnection.php';
$connect = getDatabaseConnection("final_project");
        
$username = $_POST['username'];
$password = sha1($_POST['password']);

//echo $password
$sql = "SELECT * FROM admin
        WHERE adminName = :username
        AND password = :password";


$np = array();
$np[":username"] = $username;
$np[":password"] = $password;

$stmt = $connect->prepare($sql);
$stmt->execute($np);
$record = $stmt->fetch(PDO::FETCH_ASSOC); //expecting one single record

if(empty($record)) {
    $_SESSION['incorrect'] = true;
    header("Location:adminLogin.php");
} else {
    $_SESSION['incorrect'] = false;
    $_SESSION['adminName'] = $record['adminName'];
    header("Location:admin.php");
}

?>