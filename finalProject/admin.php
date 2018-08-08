<?php
session_start();
include "dbConnection.php";

$conn = getDatabaseConnection("final_project");

if(!isset($_SESSION['adminName']))
{
    header("Location:adminLogin.php");
}

function displayPetCartCount() {
    echo count($_SESSION['cart']);
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

function displayAllPets() {
    global $conn;
    
    //SELECT * FROM `Pets` INNER JOIN `AgeGroups` ON `Pets`.`AgeGroupId` = `AgeGroups`.`AgeId`
    $sql = "SELECT * FROM Pets INNER JOIN AgeGroups ON Pets.AgeGroupId = AgeGroups.AgeId
            ORDER BY idPets";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $records;
}

function displayPendingApps() {
    global $conn;

    $sql = "SELECT * FROM Applications WHERE Approved != 'Approved' AND Approved != 'Denied'";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $records;
}

//aggregate functions
//avg cost of pets
//highest/lowest cost pet
//number of pets

function numPets() {
    global $conn;
    
    $sql = "SELECT COUNT(1)
            FROM Pets";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $record;
}

function petsWithNeeds() {
    global $conn;
    
    $sql = "SELECT COUNT(1)
            FROM Pets
            WHERE SpecialNeeds = 1";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $record;
    
}

function averagePrice() {
    global $conn;
    
    $sql = "SELECT ROUND(AVG(Price),2) AS AveragePrice
            FROM Pets";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $record;
}
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
    //INSERT INTO `Pets`(`idPets`, `DateAdded`, `Name`, `Breed`, `DOB`, `SpecialNeeds`, `Description`, `Picture`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])
    
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
        <title>Pet Adoption Admin Page </title>
        <link href="css/simpleform.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	    <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete the pet?");
            }
        </script>
        
    </head>
    <body>
        <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-primary rounded">
            <a class="navbar-brand" href="http://csumb.edu" target="_blank">CSUMB</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample09">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href='frontPage.php' id='home'>
                <i class="fp-home"></i>
                Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pets.php" id = 'pets'>
                <i class="fp-pets"></i>
                Available Pets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="petCart.php" id = 'cart'>
            <i class="petCart"></i>
                Cart: <?php displayPetCartCount();?></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="adminLogin.php" id = 'login'>
            <i class="adminLogin"></i>
                Login<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php" id = 'about'>
            <i class="about-us"></i>
                About Us</a>
            </li>
            </ul>
        </div>
        </nav>
        <h1>Admin Main Page</h1>
        <h2> Welcome <?=$_SESSION['adminName']?>!</h2>
        <br/>
        
        <div class="row justify-content-around">
            <form action="adminLogout.php">
                <input type="submit" class='btn btn-outline-danger' id="beginning" value="Logout">
                    <button type="button" class="btn btn-outline-info" data-toggle="collapse" data-target="#addPet" aria-expanded="false" aria-controls="petsTable">Add a Pet</button>
                    <!--<a class="btn btn-outline-info" href="addPet.php" role="button">Add a Pet</a>-->
            </form>
        </div>
        <br/>
        <div id="addPet" class="collapse">
            <form class="container">
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
        </div>
        <br /><br/>
        
        <div class="row justify-content-around">
            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#results" aria-expanded="false" aria-controls="results">Generate Reports</button>
            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#appsTable" aria-expanded="false" aria-controls="appsTable">Show List of Pending Applications</button>
            <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#petsTable" aria-expanded="false" aria-controls="petsTable">Show List of Pets To Update or Remove Them</button>
        </div>
        
        <div id="results" class="collapse">
            <?php
                $petCount = numPets();
                $specialNeedsCount = petsWithNeeds();
                $averagePrice = averagePrice();
                
                echo "The numbers of pets currently is: <strong>".$petCount['COUNT(1)']."</strong><br><br>";
                echo "The number of pets with special needs is: <strong>".$specialNeedsCount['COUNT(1)']."</strong><br><br>";
                echo "The average price of the pets is: <strong>$".$averagePrice['AveragePrice']."</strong><br><br>";
            ?>
        </div>
        
        <div id="petsTable" class="collapse">
            <?php
            $records=displayAllPets();
            echo "<table class='table table-hover'>";
            echo "<thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Breed</th>
                        <th scope='col'>DOB</th>
                        <th scope='col'>Date Added</th>
                        <th scope='col'>Special Needs</th>
                        <th scope='col'>Age</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Price</th>
                        <th scope='col'>Update</th>
                        <th scope='col'>Remove</th>
                    </tr>
                    </thead>";
                echo"<tbody>";
                foreach($records as $record) {
                    echo "<tr>";
                    echo "<td>" .$record['idPets']."</td>";
                    echo "<td>" .$record['Name']."</td>";
                    echo "<td>" .$record['Breed']."</td>";
                    echo "<td>" .$record['DOB']."</td>";
                    echo "<td>" .$record['DateAdded']."</td>";
                    echo "<td>" .$record['SpecialNeeds']."</td>";
                    echo "<td>" .$record['Category']."</td>";
                    echo "<td>" .$record['Description']."</td>";
                    echo "<td>$" .$record['Price']."</td>";
                    echo "<td><a class='btn btn-primary' href='updatePet.php?idpets=" . $record['idPets'] . "'>Update</a></td>";
                    
                    echo "<form action='deletePet.php' onsubmit='return confirmDelete()'>";
                    echo "<input type='hidden' name='idPets' value= " . $record['idPets'] . " />";
                    echo "<td><input type='submit' class = 'btn btn-danger' value='Remove'></td>";
                    echo "</tr>";
                    echo "</form>";
                    
                }
                echo"</tbody>";
                echo"</table>";
            ?>
        </div>
        
        <div id="appsTable" class="collapse">
            <script type="text/javascript">
            function displayPendingApps () {
                    $("#appsTable").html('');
                    $("#appsTable").append(`
                    <table id="appTable" class='table table-hover'>
                    <thead>
                        <tr>
                            <th scope='col'>ID</th>
                            <th scope='col'>Name</th>
                            <th scope='col'>E-Mail</th>
                            <th scope='col'>Care</th>
                            <th scope='col'>Any Pets</th>
                            <th scope='col'>Description</th>
                            <th scope='col'>Approve</th>
                            <th scope='col'>Deny</th>
                        </tr>
                    </thead>
                    <tbody>
                    `);
                    $.ajax({
                        type : "get",
                        url  : "getApps.php",
                        success : function(data){
                            var apps;
                            apps = JSON.parse(data);
                            for(var i = 0; i < apps.length; i++) {
                                $("#appTable").append(`
                                <tr>
                                <td>` + apps[i]['idApplication'] + `</td>
                                <td>` + apps[i]['name'] + `</td>
                                <td>` + apps[i]['email'] + `</td>
                                <td>` + apps[i]['care'] + `</td>
                                <td>` + apps[i]['anypets'] + `</td>
                                <td>` + apps[i]['description'] + `</td>
                                <td><button onclick="appApprove(` + apps[i]['idApplication'] + `)" type='button' class='btn btn-primary' id='` + apps[i]['idApplication'] + `'>Approve</button></td>
                                <td><button onclick="appDeny(` + apps[i]['idApplication'] + `)" type='button' class='btn btn-danger' id='` + apps[i]['idApplication'] + `'>Deny</button></td>
                                </tr>
                                `);
                            }
                            $("#appsTable").append("</tbody>");
                            $("#appsTable").append("</table>");
                        },
                        complete: function(data,status) { //optional, used for debugging purposes
                        }
                        
                    });
                }
            </script>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script type="text/javascript">
           displayPendingApps();
           function appApprove(id) {
                $.ajax({
                    type : "post",
                    url  : "appApproveDeny.php",
                    data : {"AppId" : id, "Approve" : "Approved"},
                    success : function(data){
                        alert("Application Approved!")
                        displayPendingApps();
                    },
                    complete: function(data,status) { //optional, used for debugging purposes
                        console.log(status);
                        console.log(data);
                    }
                });
            }
            
           function appDeny(id) {
                $.ajax({
                    type : "post",
                    url  : "appApproveDeny.php",
                    data : {"AppId" : id, "Approve" : "Denied"},
                    success : function(data){
                        alert("Application Denied!")
                        displayPendingApps();
                    },
                    complete: function(data,status) { //optional, used for debugging purposes
                        console.log(status);
                        console.log(data);
                    }
                });
            }
        </script>
    </body>
</html>