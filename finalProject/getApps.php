<?php
session_start();
include "dbConnection.php";
$conn = getDatabaseConnection("final_project");

$sql = "SELECT * FROM Application WHERE Approved IS NULL";

$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Encoding data using JSON
echo json_encode($records);
?>