<?php
    session_start();
    function displaySummary() {
        if(isset($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $pet) {
                $sum = $sum + $pet['Price'];
            }
            $taxRate = 0.0725;
            $tax = $sum * $taxRate;
            
            echo "Number of Pets Being Bought: ".count($_SESSION['cart'])."<br>";
            echo "Subtotal: $".number_format($sum, 2)."<br>";
            
            echo "Tax: $".number_format($tax, 2)."<br>";
            
            echo "Total: $".number_format($sum + $tax, 2);
        }
    }
    function displayPetCart() {
        if(isset($_SESSION['cart'])) {
            
            echo "<table class='table'>";
            echo "<thead>
                    <tr>
                        <th scope='col'>Picture</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Price</th>
                        <th scope='col'>Remove</th>
                    </tr>
                    </thead>";
            echo "<tbody>";
            foreach($_SESSION['cart'] as $pet) {
                $idPets = $pet['idPets'];
                
                echo "<tr>";
            
                echo "<td><img src='img/" . $pet['Picture'] . "'></td>";
                echo "<td><h4>". $pet['Name'] . "</h4></td>";
                echo "<td><h4>$". $pet['Price'] . "</h4></td>";
                
                echo "<form method='post'>";
                echo "<input type='hidden' name='removePet' value='$idPets'>";
                echo "<td><button class='btn btn-danger'>Remove</button></td>";
                echo "</form>";
                
                echo "</tr>";
            }
        echo"</tbody>";
        echo "</table>";
        }
    }
   
    function displayPetCartCount() {
        echo count($_SESSION['cart']);
    }
    
    if(isset($_POST['removePet'])) {
        foreach($_SESSION['cart'] as $petKey => $pet) {
            if($pet['idPets']==$_POST['removePet']) {
                unset($_SESSION['cart'][$petKey]);
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pet Cart</title>
        <link href="css/simpleform.css" rel="stylesheet" type="text/css" />
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
                <li class="nav-item active">
                <a class="nav-link" href="petCart.php" id = 'cart'>
                    <i class="petCart"></i>
                    Cart: <?php displayPetCartCount();?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="adminLogin.php" id = 'login'>
                    <i class="adminLogin"></i>
                    Login<span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="about.php" id = 'about'>
                    <i class="about-us"></i>
                    About Us</a>
                </li>
            </ul>
        </div>
        </nav>
        <h1>Pet Cart</h1>
        <!--<button type="button" class="btn btn-lg btn-primary btn-block" data-toggle="collapse" data-target="#results" aria-expanded="false" aria-controls="results">Proceed to Summary</button>-->
        <a class="btn btn-lg btn-primary btn-block" href="adoptionForm.php" role="button">Proceed to Summary</a>
        <br/>
        <!--<div id="results" class="collapse">
        <?php //displaySummary();?>
        </div>
        <br/>-->
        <?php displayPetCart(); ?>
    </body>
</html>