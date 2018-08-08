<?php
session_start();
include "dbConnection.php";
$connect = getDatabaseConnection("final_project");

$species = implode(',',$_POST['species']);
$age = implode(",",$_POST['age']);
$specialCare = $_POST['specialCare'];

$sql = "SELECT * FROM Pets
        INNER JOIN AgeGroups ON Pets.AgeGroupId=AgeGroups.AgeId
        WHERE Breed IN (" . $species . ") AND AgeGroups.Category IN (" . $age . ")";

if($specialCare == "0" || $specialCare == "1") {
    $sql = $sql . " AND SpecialNeeds = '" . $specialCare . "'";
}


$stmt = $connect->prepare($sql);
$stmt->bindParam(':species', $species);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Encoding data using JSON
echo json_encode($result);
?>