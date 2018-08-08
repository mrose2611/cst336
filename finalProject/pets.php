<?php
session_start();
include 'dbConnection.php';

$conn = getDatabaseConnection("final_project");

if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
}

if(isset($_POST['idPets'])) {
    $newPet = array();
    $newPet['idPets'] = $_POST['idPets'];
    $newPet['Name'] = $_POST['Name'];
    $newPet['Picture'] = $_POST['Picture'];
    $newPet['Price'] = $_POST['Price'];
    
    foreach($_SESSION['cart'] as &$pet) {
        if($newPet['idPets'] == $pet['idPets']) {
            $found = true;
        }
    }
    
    if($found != true) {
        array_push($_SESSION['cart'], $newPet);
    }
}

function displayBreeds() {
    global $conn;
    
    $sql = "SELECT DISTINCT Breed FROM Pets ORDER BY Breed";

    $stmt = $conn->prepare($sql);
    $stmt->execute($param);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($records as $record) {
        echo "<br><input class='speciesBox' type='checkbox' id='species" . $record["Breed"] . "' name='species[]' value='" . $record["Breed"] . "' checked>";
        echo "<label for='species" . $record["Breed"] . "'>" . $record["Breed"] . "</label>";
    }
}

function displayAgeGroup() {
    global $conn;
    
    $sql = "SELECT DISTINCT Category,AgeId FROM AgeGroups ORDER BY AgeId";

    $stmt = $conn->prepare($sql);
    $stmt->execute($param);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($records as $record) {
        echo "<br><input class='ageBox' type='checkbox' id='age" . $record["Category"] . "' name='age[]' value='" . $record["Category"] . "' checked>";
        echo "<label for='age" . $record["Category"] . "'>" . $record["Category"] . "</label>";
    }
}

function displayPetCartCount() {
    echo count($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pet Shelter </title>
        <link href="css/simpleform.css" rel="stylesheet" type="text/css" />
        <link href="css/petspage.css" rel="stylesheet" type="text/css" />
        <script src="js/petsFunctions.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
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
              
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href='frontPage.php' id='home'>
                    <i class="fp-home"></i>
                    Home</a>
            </li>
              <li class="nav-item active">
                <a class="nav-link" href="pets.php" id = 'pets'>
                    <i class="fp-pets"></i>
                    Available Pets</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="petCart.php" id = 'cart'>
                    <i class="petCart"></i>
                    Cart: <?php displayPetCartCount();?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="adminLogin.php" id = 'login'>
                    <i class="adminLogin"></i>
                    Login</a>
              </li>
                <li class="nav-item">
                <a class="nav-link" href="about.php" id = 'about'>
                    <i class="about-us"></i>
                    About Us</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Pet Filter
                </a>
                <div class="dropdown-menu">
                  <form class="px-4 py-3">
                    <label for="species"><strong>Species:</strong></label>
                        <?=displayBreeds()?>
                    <button type="button" class='btn species' id="speciesSelect" onclick="selectAll('.speciesBox')">&#10004;</button> <button type="button" class='btn species' id="speciesUnselect" onclick="unselectAll('.speciesBox')">&#10006;</button>
                    <hr>
                    <label for="species"><strong>Age Group:</strong></label><br>
                    <input class="ageBox" type="checkbox" id="age1"  name="age[]" value="young" checked>
                    <label for="age1"> Young </label><br>
                    <input class="ageBox" type="checkbox" id="age2" name="age[]" value="adult" checked>
                    <label for="age2"> Adult </label><br>
                    <input class="ageBox" type="checkbox" id="age3"  name="age[]" value="senior" checked>
                    <label for="age3"> Senior </label>
                    <button type="button" class='btn age' id="ageSelect" onclick="selectAll('.ageBox')">&#10004;</button> <button type="button" class='btn age' id="ageUnselect" onclick="unselectAll('.ageBox')">&#10006;</button>
                    <hr>
                    Special Care:
                    <select id="specialCare" name="Special Care">
                        <option value="Both">Both</option>
                        <option value="Yes"> Yes </option>
                        <option value="No"> No </option>
                    </select>
                    <hr>
                    <div class='text-center'><button type="button" class='btn' id="filterbtn">Filter</button></div>
                    </form>
                </div>
              </li>
              
          </ul>
        </div>
        </nav>
        <h1 class="text-center">Available Pets</h1>
        <div id="petsArea">
            
        </div>
        <script type="text/javascript">
            $("petsArea").html("");
            filterPets();
            $("#filterbtn").on("click", function() {
                console.log("event");
                filterPets();
            });
        </script>
        
    </body>
</html>