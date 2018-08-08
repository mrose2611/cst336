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
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Adoption Application</title>
        <link href="css/simpleform.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $("#submit").click(function(){
                    var name=$("#name").val();
                    var email=$("#email").val();
                    var care=$("#care").val();
                    var anypets=$("#anypets").val();
                    var description=$("#description").val();
                    var dataString = 'name='+ name + '&email=' + email
                                        + '&care=' + care + '&anypets=' + anypets
                                        +'&description='+description;
                if(name==''||email==''||care==''||anypets==''||description==''){
                    alert("Please fill out all fields.");
                }else{
                $.ajax({
                   url:'submitForm.php',
                   method:'POST',
                   data: dataString,
				   cache: false,
				   success: function(result){
				    alert(result);
				    alert("Submission Successful!")
                    }
                });
                }
                return false;
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
        <h2>Summary of Purchase</h2>
        <?php displaySummary();?>
        <br><br>
        <a class="btn btn-primary" href="petCart.php" role="button">Go Back to Cart</a>
        <form method='post' action="" onSubmit="return post();">
        <h1>Adoption Application</h1>
        <div class="form-control">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-control">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-control">
            <label for="care"><strong>Can you afford to take your pet to the veterinary?</strong></label><br>
            <input type="radio" name="care" id="care" value = '1'> Yes <br>
            <input type="radio" name="care" id="care" value = '0'> No
            <br>
        </div>
        <div class="form-control">
            <label for="anypets"><strong>Do you currently have pets and know how to introduce them?</strong></label><br>
            <input type="radio" name="anypets" id="anypets" value = '1'> Yes <br>
            <input type="radio" name="anypets" id="anypets" value = '0'> No
            <br>
        </div>
        <div class="form-control">
            <label for="description"><strong>Briefly describe your home and family dynamic.</strong></label><br>
            <textarea name="description" id="description" class="form-control" cols=50 rows=4 placeholder="Describe here"></textarea>
            <br>
        </div>
        <div class="form-control">
            <input type="submit" id= "submit" name="submit" class='btn btn-primary' value="Submit Application">
        </div>
        </form>
        </div>
    </body>
</html>
