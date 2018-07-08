<?php

include 'dbConnection.php';

$conn = getDatabaseConnection("ottermart");

function displayCategories() {
    global $conn;
    
    $sql = "SELECT catId, catName from om_category ORDER BY catName";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //print_r($records); //Can be used to view results
    
    foreach ($records as $record) {
        
        echo "<option value='".$record["catId"]."' >" . $record["catName"] . "</option>";
        
    }
}

function displaySearchResults(){
    global $conn;
    
    if (isset($_GET['searchForm'])) { //checks if the user has submitted the form
        
        echo "<h3>Products Found: </h3>";
        //Query below prevents SQL injection
        $namedParameters = array();
        
        $sql = "Select * FROM om_product WHERE 1";
        
        if(!empty($_GET['product'])) { //checks if the user has typed something in the Product box
            $sql .= " AND productName LIKE :productName";
            $namedParameters[":productName"] = "%" . $_GET['product'] . "%";
        }
        
        if (!empty($_GET['category'])) { //checks if user has selected a category
            $sql .= " AND catId = :categoryId";
            $namedParameters[":categoryId"] = $_GET['category'];
        }
        
        if (!empty($_GET['priceFrom'])) {
            $sql .= " AND price >= :priceFrom";
            $namedParameters[":priceFrom"] = $_GET['priceFrom'];
        }
        
        if (!empty($_GET['priceTo'])) {
            $sql .= " AND price <= :priceTo";
            $namedParameters[":priceTo"] = $_GET['priceTo'];
        }
        
        if (isset($_GET['orderBy'])) {
            
            if($_GET['orderBy'] == "price") {
                $sql .= " ORDER BY price";
            } else {
                $sql .= " ORDER BY productName";
            }
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($namedParameters);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($records as $record) {
            
            echo "<a href=\"purchaseHistory.php?productId=".$record["productId"]. "\"> History </a>";
            
            echo $record["productName"] . " " . $record["productDescription"] . " $" . $record["price"] . "<br /><br />";
        }
        
    }
}

?>

<!DOCTYPE html>
<html>
    
    <head>
        <title> OtterMart Product Search </title>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        
        <div id="formWindow">
            <img id="logo" src="img/csumb_logo.jpg" alt="Picture of CSUMB's logo" />
            <h1> OtterMart Product Search </h1>
            <form>
                <span class="topic"> Product: </span><input type="text" name="product" />
                <br>
                <span class="topic">Category: </span>
                    <select name="category">
                        <option value=""> Select One </option>
                        <?=displayCategories()?>
                    </select>
                <br>
                <span class="topic">Price: </span><span class="toAndFrom">From</span> <input type="text" name="priceFrom" size="7" />
                       <span class="toAndFrom">To   </span><input type="text" name="priceTo" size="7" />
                <br>
                <span class="order">Order result by: </span>
                <br>
                
                <div id="radioButtons">
                <input type="radio" name="orderBy" value="price" /> Price <br>
                <input type="radio" name="orderBy" value="name" /> Name 
                </div>
                
                <br />
                <input id="submitButton" type="submit" value="Search" name="searchForm" />
                
            </form>
            
            <br />
            
        </div>
        
        <hr>
        <div id="searchResults">
        <?= displaySearchResults() ?>
        </div>
    </body>
</html>