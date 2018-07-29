<?php
    include 'inc/header.php';
    
    $imageArray = array();
    
    foreach($pets as $pet){
        
        array_push($imageArray, $pet['pictureURL']);
        
    }
    
    $size = count($imageArray);
?>
        <!-- add Carousel component -->
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="width:300px">
            <!-- Indicators Here -->
            <ol class="carousel-indicators">
                <?php
                    for($i = 0; $i < $size; $i++) {
                        echo "<li data-target='#carousel-example-generic' data-slide-to='$i'";
                        echo ($i==0)?" class='active'": "";
                        echo "></li>";
                    }
                ?>
            </ol>
            <!-- Wrapper for Images -->
            <div class="carousel-inner" role="listbox">
                <?php
                    for ($i = 0; $i < $size; $i++) {
                        echo '<div class="carousel-item ';
                        echo ($i==0)?"active": "";
                        echo '">';
                        echo '<img src="img/' . $imageArray[$i] . '">';
                        echo '</div>';
                        //unset($imageArray[$i]);
                    }
                ?>
            </div>
            
        <!-- Controls -->
        <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>
        
        <br /><br />
        <a class="btn btn-outline-primary" href="pets.php" role="button">Adopt Now!</a>
        <br /><br />
        <hr>
<?php
    include 'inc/footer.php';
?>