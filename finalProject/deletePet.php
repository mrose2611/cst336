<?php
    include "dbConnection.php";
    
    $conn = getDatabaseConnection("final_project");
    
    $sql = "DELETE
            FROM Pets
            WHERE idPets = " . $_GET['idPets'];
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    header("Location:admin.php");
?>