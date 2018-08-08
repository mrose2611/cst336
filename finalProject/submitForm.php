<?php
    session_start();
    include "dbConnection.php";
    $conn = getDatabaseConnection("final_project");
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $care = $_POST['care'];
    $anypets = $_POST['anypets'];
    $description = $_POST['description'];
    
    $sql = "INSERT INTO Application
                (name, email, care, anypets, description) 
                VALUES(:name, :email, :care, :anypets, :description)";
    
    $data = array(":name" => $name,":email" => $email, ":care" => $care,
                    ":anypets" => $anypets, ":description" => $description);
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    
?>