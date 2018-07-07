<?php
    
    $sportError = $genderError = $colorsError = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if(!empty($_POST['sport'])) {
            $sport = $_POST['sport'];
        }
        else {
            $sportError = "Please select a sport.";
        }
        
        if(!empty($_POST['gender'])) {
            $gender = $_POST['gender'];
        }
        else {
            $genderError = "Please select a gender.";
        }
        
        if(!empty($_POST['colors'])) {
            $colors = $_POST['colors'];
        }
        else {
            $colorsError = "Please select a color.";
        }
    
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Homework 3</title>
        <meta charset="utf-8">
        <style>
            @import url("css/styles.css");
        </style>
    </head>

    <body>
        <header>
            <h1>Sport Shirt Viewer</h1>
        </header>
        <hr />
        <p id= "instructions"><strong>Instructions:</strong> Pick a sport, gender, and some colors to view some shirts for that sport.  
        Note that there is only one shirt per gender/color combination.</p>
        <br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <select name = "sport" style="color:black">
                <option value = "">Select a Sport</option>
                <option value = "bowling" <?= $sport == "bowling" ? "selected" : "" ?>>Bowling</option>
                <option value = "cycling" <?= $sport == "cycling" ? "selected" : "" ?>>Cycling</option>
                <option value = "golf" <?= $sport == "golf" ? "selected" : "" ?>>Golf</option>
                <option value = "tennis" <?= $sport == "tennis" ? "selected" : "" ?>>Tennis</option>
            </select>
            <br>
            <span class="errors"><?php echo $sportError ?></span>
            
            <div id="radioButtonDiv">
                <fieldset class="selectors">
                    <legend>Gender: <span class="required">*</span></legend>
                    <input type="radio" id="rmale" name="gender" value="male" <?= $gender == "male" ? "checked" : "" ?>>
                    <label for="rmale"> Male </label>
                    <br>
                    <input type="radio" id="rfemale" name="gender" value="female" <?= $gender == "female" ? "checked" : "" ?>>
                    <label for="rfemale"> Female </label>
                    <br>
                    <span class="errors"><?php echo $genderError ?></span>
                </fieldset>

            </div>
            <fieldset class="selectors">
                <legend>Color: <span class="required">*</span></legend>
                <input type="checkbox" id="red" name="colors[]" value="red" <?= in_array("red",$colors) ? "checked" : "" ?>>
                <label for="red" id="radioRed"> Red </label>
                <input type="checkbox" id="green" name="colors[]" value="green" <?= in_array("green",$colors) ? "checked" : "" ?>>
                <label for="green" id="radioGreen"> Green </label>
                <input type="checkbox" id="blue" name="colors[]" value="blue" <?= in_array("blue",$colors) ? "checked" : "" ?>>
                <label for="blue" id="radioBlue"> Blue </label>
                <input type="checkbox" id="white" name="colors[]" value="white" <?= in_array("white",$colors) ? "checked" : "" ?>>
                <label for="white" id="radioWhite"> White/Grey </label>
                <br>
                <span class="errors"><?php echo $colorsError ?></span>
            </fieldset>

            <br>
            <input type="submit" id="submitButton" value="Show me some shirts!"/>
        </form>
        <br>
        <div id="imagesContainer">
        <?php
            if(isset($sport) and isset($gender) and isset($colors)) {
                foreach($colors as $selected) {
                    $imageLoc =  "img/".$sport."/".$gender."_".$selected."_".$sport."_shirt.png";
                    echo "<img src='$imageLoc' class='images' alt='A $gender $selected $sport shirt.'>";
                    echo " ";
                }  
            }
            else {
                echo "<p id= 'errorText'> Please complete all fields.</p>";
            }
        ?>
        </div>
        <footer>
            <hr>
            CST 336. 2018&copy; Rose <br />
            <strong>Disclaimer:</strong> While the information on this webpage is not ficticious,it is not meant to be a source to be cited.  This is a homework assignment. <br />
            <br />
            <img id="footerImage" src="img/csumb_logo.jpg" alt="Picture of CSUMB's logo" />
        </footer>
    </body>
</html>