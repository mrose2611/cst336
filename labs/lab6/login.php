<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title> OtterMart Admin Page </title>
        <link rel="stylesheet" href="styles.css">
    </head>
    
    <body>
        <h1> OtterMart Admin Page</h1>
        <img id= "csulogo" src="csumb_logo.jpg">
        <form method="POST" action="loginProcess.php">
            Username: <input type="text" name="username"/> <br />
            Password: <input type="password" name="password"/> <br />
            
            <input type="submit" name="submitForm" value="Login!" />
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