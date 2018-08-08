<?php
    session_start();
    
    function displayPetCartCount() {
      echo count($_SESSION['cart']);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pet Adoption</title>
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
            <li class="nav-item active">
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
            </ul>
        </div>
        </nav>
        <div class="jumbotron">
        <h1>Code Blooded Pet Shelter</h1>
        <h3>We have the cutest pets in town!</h3>
        <p>Please enter our website and adopt one of our precious friends today! Each one has been groomed to perfection and will love you unconditionally. We like to make sure
        the right people are taking out family home so we like to schedule meet and greets for all approved 
        families. Thank you so much for the support!</p>
        </div>
        <a class="btn btn-lg btn-outline-primary btn-block" href="pets.php" role="button">Adopt Now!</a>
    </body>
</html>