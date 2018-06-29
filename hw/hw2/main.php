<?php
include 'inc/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Amazing Squirrel Facts! </title>
        <style>
            @import url("css/styles.css");
        </style>
    </head>
    <body>
            <header>
                <h1>Amazing Squirrel Facts!</h1>
            </header>
            <hr />
        <div id="main">
            <?php
            displayImage($imageArray);
            ?>
        </div>
        
            <form>
                <input type="submit" value="Another Fact" />
            </form>
        <br />
        <footer>
            <hr>
            CST 336. 2018&copy; Rose <br />
            <strong>Disclaimer:</strong> While the information on this webpage is not ficticious,it is not meant to be a source to be cited.  This is a homework assignment. <br />
            <br />
            <img id="footerImage" src="img/csumb_logo.jpg" alt="Picture of CSUMB's logo" />
        </footer>
    </body>
</html>