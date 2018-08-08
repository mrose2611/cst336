<?php
    include "dbConnection.php";
    
    $conn = getDatabaseConnection("final_project");
    
    function displayBreeds() {
    global $conn;
    
    $sql = "SELECT DISTINCT Breed FROM Pets ORDER BY Breed";

    $stmt = $conn->prepare($sql);
    $stmt->execute($param);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($records as $record) {
        echo "<option value='" . $record["Breed"] . "' >" . $record["Breed"] . "</option>";
    }
}

function displayAges() {
    global $conn;
    
    $sql = "SELECT * FROM AgeGroups";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($records as $record) {
        echo "<option value=".$record["AgeId"] . ">" . $record["Category"]. "</option>";
    }
}
    //INSERT INTO `Pets`(`idPets`, `DateAdded`, `Name`, `Breed`, `DOB`, `AgeGroupId`, `SpecialNeeds`, `Description`, `Picture`, `Price`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10])
    if(isset($_GET['submitPet'])) {
        $name = $_GET['name'];
        $breed = $_GET['breed'];
        $dob = $_GET['dob'];
        $specialNeeds = $_GET['specialNeeds'];
        $description = $_GET['description'];
        $picture = $_GET['picture'];
        $age = $_GET['age'];
        $price = $_GET['price'];
        
        $sql1 = "INSERT INTO Pets
                (DateAdded, Name, Breed, DOB, AgeGroupId, SpecialNeeds, Description, Picture, Price) 
                VALUES (CURRENT_DATE, :name, :breed, :dob, :age, :specialNeeds, :description, :picture, :price)";
        
        $np = array();
        $np['name'] = $name;
        $np['breed'] = $breed;
        $np['dob'] = $dob;
        $np['specialNeeds'] = $specialNeeds;
        $np['description'] = $description;
        $np['picture'] = $picture;
        $np['age'] = $age;
        $np['price'] = $price;
        
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute($np);
        
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Pet</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    </head>
    <body>
        <form class="container">
            <a class="btn btn-outline-primary btn-block" href="admin.php" role="button">Back to Admin Page</a>
            <br/><br/>
            <strong>Pet Name</strong> <input type="text" class="form-control" name="name"><br>
            
            <strong>Breed</strong> <select name="breed" class="form-control">
                <option value="">Select One</option>
                <?php displayBreeds(); ?>
            </select> <br />
            
            <strong>Date of Birth</strong> <input type="date" class="form-control" name="dob"><br>
            
            <strong>Set Image Url</strong> <input type="text" name="picture" class="form-control"><br>
            
            <strong>Special Needs</strong><br>
            <input type="radio" name="specialNeeds" value = '1'> Yes <br>
            <input type="radio" name="specialNeeds" value = '0'> No
            <br>
            
            <strong>Set Age</strong><select name="age" class="form-control">
                <option value="">Select One</option>
                <?php displayAges(); ?>
            </select> <br />
            <strong>Set Price</strong> <input type="text" name="price" class="form-control"><br>
            
            <strong>Description</strong> <textarea name="description" class="form-control" cols=50 rows=4></textarea><br>
            
            <input type="submit" name="submitPet" class='btn btn-primary btn-block' value="Add Pet">
            <br>
        </form>
    </body>
</html>