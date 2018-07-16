<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title> OtterMart Admin Page </title>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    </head>
    
    <body>
        <h1> OtterMart Admin Page</h1>
        <img id= "csulogo" src="csumb_logo.jpg">
        <div class="form-group row col-5">
        <form method="POST" action="loginProcess.php">
            Username: <input type="text" name="username"/> <br />
            Password: <input type="password" name="password"/> <br />
            
            <input type="submit" class='btn btn-primary' name="submitForm" value="Login!" />
            <br /><br />
            <?php
                if($_SESSION['incorrect']) {
                    echo "<p class = 'lead' id='error' style='color:red'>";
                    echo "<strong>Incorrect Username or Password!</strong></p>";
                }
            ?>
        </form>
        </div>
    </body>
</html>