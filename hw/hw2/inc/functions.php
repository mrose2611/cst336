<?php 

function displayImage(){
            $imageArray = array(); //create array of images and populate it
            
            for($i=1; $i<=10;$i++) {
                array_push($imageArray, "squirrel" . $i);
            }

            $displayImage1 = array_rand($imageArray);
            
            //this loop makes sure that the second image is not the same as the first
            do {
                $displayImage2 = array_rand($imageArray);
            }while($displayImage2 == $displayImage1);
            
            switch ($displayImage1) {
                    case 0: $description1 = "Squirrel on a large branch.";
                            break;
                    case 1: $description1 = "Squirrel eating various nuts.";
                            break;
                    case 2: $description1 = "Two squirrel with one kissing the other. Adorable.";
                            break;
                    case 3: $description1 = "Squirrel up in a tree.";
                            break;
                    case 4: $description1 = "Squirrel in a tree looking at the camera.";
                            break;
                    case 5: $description1 = "Squirrel sniffing a flower.";
                            break;
                    case 6: $description1 = "Three squirrels on a tree with one in a hollow.";
                            break;
                    case 7: $description1 = "Squirrel trying to grab a peanut that has fallen.";
                            break;
                    case 8: $description1 = "Squirrel sniffing around the grass for food.";
                            break;
                    case 9: $description1 = "Squirrel eating a nut.";
                            break;
            }
            
            switch ($displayImage2) {
                    case 0: $description2 = "Squirrel on a large branch.";
                            break;
                    case 1: $description2 = "Squirrel eating various nuts.";
                            break;
                    case 2: $description2 = "Two squirrel with one kissing the other. Adorable.";
                            break;
                    case 3: $description2 = "Squirrel up in a tree.";
                            break;
                    case 4: $description2 = "Squirrel in a tree looking at the camera.";
                            break;
                    case 5: $description2 = "Squirrel sniffing a flower.";
                            break;
                    case 6: $description2 = "Three squirrels on a tree with one in a hollow.";
                            break;
                    case 7: $description2 = "Squirrel trying to grab a peanut that has fallen.";
                            break;
                    case 8: $description2 = "Squirrel sniffing around the grass for food.";
                            break;
                    case 9: $description2 = "Squirrel eating a nut.";
                            break;
            }
            echo "<div id = 'factImages'>";
            echo "<img class = 'squirrelImage' id='image$displayImage1' src='img/$imageArray[$displayImage1].jpg' alt='$description1' title='". ucfirst($description1) ."' />";
            echo "<img class = 'squirrelImage' id='image$displayImage2' src='img/$imageArray[$displayImage2].jpg' alt='$description2' title='". ucfirst($description2) ."' />";
            echo "</div>";
            echo "\n\n";
            
            $displayFact = rand(0, count($imageArray) - 1);
            
            switch ($displayFact) {
                    case 0: $fact = "Some species of squirrel are able to smell food under a foot of snow. <br><br> <span class = 'source'>Source: <a href='http://blog.nwf.org/2015/01/10-nutty-facts-to-make-you-appreciate-squirrels/' target='_blank'>National Wildlife Federation's Blog</a></span>"; //Source: http://blog.nwf.org/2015/01/10-nutty-facts-to-make-you-appreciate-squirrels/
                            break;
                    case 1: $fact = "Squirrels have been observed pretending to bury their food in order to deceive potential thieves. <br><br> <span class = 'source'>Source: <a href='http://blog.nwf.org/2015/01/10-nutty-facts-to-make-you-appreciate-squirrels/' target='_blank'>National Wildlife Federation's Blog</a></span>"; //Source: http://blog.nwf.org/2015/01/10-nutty-facts-to-make-you-appreciate-squirrels/
                            break;
                    case 2: $fact = "Squirrels are not just herbivores.  There are species that feed on insects, smaller rodents, small birds, and eggs. <br><br> <span class = 'source'>Source: <a href='https://facts.net/squirrel/' target='_blank'>facts.net</a></span>"; //Source: https://facts.net/squirrel/
                            break;
                    case 3: $fact = "Red squirrels enjoy eating mushrooms. In fact, these squirrels have been observed collecting fungi and then hanging it out to dry. <br><br> <span class = 'Source'>Source: <a href='https://facts.net/squirrel/' target='_blank'>facts.net</a></span>"; //Source: https://facts.net/squirrel/
                            break;
                    case 4: $fact = "In California, squirrels have been observed to chew on dead rattlesnake skin and smear it on their fur.  This is most likely to make potential predators think that another snake is in the area and not a squirrel. <br><br> <span class = 'source'>Source: <a href='https://facts.net/squirrel/' target='_blank'>facts.net</a></span>"; //Source: https://facts.net/squirrel/
                            break;
                    case 5: $fact = "Squirrels are capable of leaping 10 times their body length and can turn their ankles 180 degrees. <br><br> <span class = 'source'>Source: <a href='https://www.thefactsite.com/2014/12/fun-squirrel-facts.html' target='_blank'>thefactssite.com</a></span>"; //Source: https://www.thefactsite.com/2014/12/fun-squirrel-facts.html
                            break;
                    case 6: $fact = "Squirrels have 4 toes on their front feet and 5 toes on their back feet. <br><br> <span class = 'source'>Source: <a href='https://www.thefactsite.com/2014/12/fun-squirrel-facts.html' target='_blank'>the facts site.com</a></span>"; //Source: https://www.thefactsite.com/2014/12/fun-squirrel-facts.html
                            break;
                    case 7: $fact = "There are over 285 species of squirrels which can be found in every continent except Antarctica and Australia. <br><br> <span class = 'source'>Source: <a href='https://www.thefactsite.com/2014/12/fun-squirrel-facts.html' target='_blank'>thefactssite.com</a></span>"; //Source: https://www.thefactsite.com/2014/12/fun-squirrel-facts.html
                            break;
                    case 8: $fact = "Squirrels can fall from approximately 30 meters (approx. 98.4 feet) high without hurting themselves. <br><br> <span class = 'source'>Source: <a href='https://www.thefactsite.com/2014/12/fun-squirrel-facts.html' target='_blank'>thefactssite.com</a></span>"; //Source: https://www.thefactsite.com/2014/12/fun-squirrel-facts.html
                            break;
                    case 9: $fact = "Squirrels can run as fast as 20 miles per hour though their average is about 10 miles per hour. <br><br> <span class = 'source'>Source: <a href='https://www.thefactsite.com/2014/12/fun-squirrel-facts.html' target='_blank'>thefactssite.com</a></span>"; //Source: https://www.thefactsite.com/2014/12/fun-squirrel-facts.html
                            break;
            }
            
            echo "<p id=fact> $fact </p>";
    }

function go() {
    displayImage();
}
?>

