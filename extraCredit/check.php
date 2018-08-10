<?php
session_start();

include 'dbConnection.php';
$connect = getDatabaseConnection("extra_credit");

$keyword = $_POST['search'];

$sql = "SELECT *
        FROM search_results
        WHERE keyword = :keyword";

$stmt = $connect->prepare($sql);
$stmt->execute(array(":keyword"=>$keyword));
$result = $stmt->fetch(PDO::FETCH_ASSOC);

//INSERT INTO `search_results`(`keyword`, `timesSearched`) VALUES ([value-1],[value-2])
if($result == null) {
    $sql1 = "INSERT INTO search_results (keyword, timesSearched)
             VALUES (:keyword, 1)";
    $stmt1 =$connect->prepare($sql1);
    $stmt1->execute(array(":keyword"=>$keyword));
}
//UPDATE `search_results` SET `keyword`=[value-1],`timesSearched`=[value-2] WHERE 1
else {
    $sql2 = "UPDATE search_results
             SET timesSearched = timesSearched + 1
             WHERE keyword = :keyword";
    $stmt2 = $connect->prepare($sql2);
    $stmt2->execute(array(":keyword"=>$keyword));
}

$finalSql = "SELECT *
             FROM search_results
             WHERE keyword = :keyword";
$finalStmt = $connect->prepare($finalSql);
$finalStmt->execute(array(":keyword"=>$keyword));
$finalResult = $finalStmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($finalResult);
?>