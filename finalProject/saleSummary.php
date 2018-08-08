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
        <title>Summary Page</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    </head>
    <body>
        <h2>Summary of Purchase</h2>
        <?php displaySummary();?>
        <br><br>
        <a class="btn btn-outline-primary" href="petCart.php" role="button">Go Back to Cart</a>
    </body>
</html>