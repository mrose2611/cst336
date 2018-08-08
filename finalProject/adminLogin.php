<?php

include 'dbConnection.php';

session_start();

$conn = getDatabaseConnection("final_project");

    function displayPetCartCount() {
        echo count($_SESSION['cart']);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Login</title>
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
        <form method="POST" action="loginProcess.php" class="form-signin">
            <h2 class="form-signin-heading">Log In</h2>
            <label for="user" class="sr-only">Username:</label>
            <input type="text" id="user" name="username" class="form-control" placeholder="User Name" required><br />
            <label for="userpassword" class="sr-only">Password:</label>
            <input type="password" id="userpassword" class="form-control" placeholder="Password" name="password" required><br />
            
            <input type="submit" class='btn btn-lg btn-primary btn-block' name="submitForm" value="Login!" />
            <br /><br />
            <?php
                if($_SESSION['incorrect']) {
                    echo "<p class = 'lead' id='error' style='color:red'>";
                    echo "<strong>Incorrect Username or Password!</strong></p>";
                }
            ?>
        </form>
    </body>
</html>