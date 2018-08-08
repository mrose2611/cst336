<?php
    include "dbConnection.php";
    
    $conn = getDatabaseConnection("final_project");
    
        
    if(isset($_GET['idpets'])) {
        $pet = getPetInfo();
    }
    
    
    function getPetInfo(){
        global $conn;
        
        $sql = "SELECT *
                FROM Pets
                WHERE idPets = " . $_GET['idpets'];
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $record;
    }
    
    function displayBreeds($breed) {
        global $conn;
        
        $sql = "SELECT DISTINCT Breed FROM Pets ORDER BY Breed";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute($param);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($records as $record) {
            echo "<option ";
            echo ($record["Breed"] == $breed?"selected": "");
            echo " value='" . $record["Breed"] . "' >" . $record["Breed"] . "</option>";
        }
    }
    
    function displayAges($age) {
        global $conn;
        
        $sql = "SELECT * FROM AgeGroups";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($records as $record) {
            echo "<option ";
            echo ($record["AgeId"]== $age?"selected": "");
            echo " value=".$record["AgeId"] . ">" . $record["Category"]. "</option>";
        }
    }
    
    //UPDATE `Pets` SET `idPets`=[value-1],`DateAdded`=[value-2],`Name`=[value-3],`Breed`=[value-4],`DOB`=[value-5],`SpecialNeeds`=[value-6],`Description`=[value-7],`Picture`=[value-8] WHERE 1
    if(isset($_GET['updatePet'])) {
        
        $sql1 = "UPDATE Pets
                 SET Name = :Name,
                    Breed = :Breed,
                    DOB = :DOB,
                    SpecialNeeds = :SpecialNeeds,
                    Description = :Description,
                    Picture = :Picture,
                    Price = :Price,
                    AgeGroupId = :Age
                 WHERE idPets = :idPets";
        
        $np = array();
        $np['Name'] = $_GET['Name'];
        $np['Breed'] = $_GET['Breed'];
        $np['DOB'] = $_GET['DOB'];
        $np['SpecialNeeds'] = $_GET['SpecialNeeds'];
        $np['Description'] = $_GET['Description'];
        $np['Picture'] = $_GET['Picture'];
        $np['idPets'] = $_GET['idPets'];
        $np['Age'] = $_GET['age'];
        $np['Price'] = $_GET['price'];
        
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute($np);
        
        echo "Pet updated.";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Pet Page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    </head>
    <body>
        <h1>Update Pet</h1><br>
        <div class="form-group row-2 col-5">
        <form>
            <input type="hidden" name="idPets" value="<?=$pet['idPets']?>"/>
            <strong>Pet Name</strong> <input type="text" class="form-control" name="Name" value="<?=$pet['Name']?>"><br>
            
            <strong>Breed</strong> <select name="Breed" class="form-control">
                <option value="">Select One</option>
                <?php displayBreeds($pet['Breed'] ); ?>
            </select> <br />
            
            <strong>Date of Birth</strong> <input type="date" class="form-control" name="DOB" value="<?=$pet['DOB']?>"><br>
            
            <strong>Set Image Url</strong> <input type="text" name="Picture" class="form-control" value="<?=$pet['Picture']?>"><br>
            
            <strong>Special Needs</strong><br>
            <input type="radio" name="SpecialNeeds" value = '1' <?=$pet['SpecialNeeds'] == 1?"checked": ""?>> Yes <br>
            <input type="radio" name="SpecialNeeds" value = '0' <?=$pet['SpecialNeeds'] == 0?"checked": ""?>> No  <br>
            
            <strong>Set Age</strong><select name="age" class="form-control">
                <option value="">Select One</option>
                <?php displayAges($pet['AgeGroupId']); ?>
            </select> <br />
            
            <strong>Set Price</strong> <input type="text" name="price" class="form-control" value="<?=$pet['Price']?>"><br>
            
            <strong>Description</strong> <textarea name="Description" class="form-control" cols=50 rows=4><?=$pet['Description']?></textarea><br>

            <input type="submit" name="updatePet" class='btn btn-primary' value="Update Pet">
        </form>
        </div>
        <br>
        <a class="btn btn-outline-primary" href="admin.php" role="button">Back to Admin Page</a>
        <br><br>
    </body>
</html>