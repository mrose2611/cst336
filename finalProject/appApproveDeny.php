<?php
session_start();
include "dbConnection.php";
$connect = getDatabaseConnection("final_project");

$status = $_POST['Approve'];
$id = $_POST['AppId'];

$sql = "UPDATE Application
        SET Approved = :status
        WHERE idApplication = :id";

$data = array(
    ":status" => $status,
    ":id" => $id
);

$stmt = $connect->prepare($sql);
$stmt->execute($data);

echo json_encode($id);
?>