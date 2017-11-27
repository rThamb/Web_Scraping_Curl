<html>

<head>
	<link href="myStyle.css" type="text/css" rel="stylesheet">

	<title> Php Assignment</title>
</head>


<body>


    <div class="backgroundImgChange">
            
        <h1> <u>Food Gawker</u> </h1>
    
        <h2 class="header"> Renuchan, Dimitri </h2> 
        
    </div>



    <div class="outerBox">

    <br />

    <form action="" method="POST">
        <label> Search Recipe <input type="text" name="searchValue" value="<?php if(isset($_POST['searchValue'])) echo $_POST['searchValue'];?>"/> </label> 

                    <input type="submit" value="Search"/> 
    </form>

    <div class="innerBox">
                            
        <h2>Welcome Hope You Enjoy</h2>

        <table width='100%'>
            
        <?php

            require('recipe.php'); 

            try{
                if($_SERVER['REQUEST_METHOD'] == "POST")
                {

                    $key = $_POST['searchValue']; 
                    $key = "%$key%";

                    $pdo = new PDO('mysql:host=localhost;dbname=homestead','homestead','secret'); 

                    $query = "select * from RecipeInfo where description like ? order by view DESC;"; 

                    $stmt = $pdo -> prepare($query);

                    $stmt ->bindValue(1,$key);

                    $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'recipe'); 

                    $stmt ->execute();

                    while($row = $stmt -> fetch())
                    {

                        $title = $row -> getTitle();
                        $des = $row -> getDes();
                        $link = $row -> getLink();
                        $views = $row -> getView();
                        $person = $row -> getName(); 

                        $html = "<tr><th colspan='5'><a href='$link'>$title</th><th colspan='3'>$person</th><th colspan='2'>$views</th></tr><tr><td colspan='10'>$des</td></tr>";

                        echo $html; 

                    }
                }
                else
                {
                    displayToGawkers();
                }
                
            }
            catch(SQLException $e)
            {
                echo "PROBLEM" . $e -> getMessage(); 
            }


            function displayToGawkers()
            {
                try{
                    $pdo = new PDO('mysql:host=localhost;dbname=homestead','homestead','secret'); 

                    $query = "select name, sum(view) AS view from RecipeInfo group by name order by sum(view) DESC;"; 

                    $stmt = $pdo -> prepare($query);

                    $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'recipe'); 

                    $stmt ->execute();

                    
                    echo "<tr><th colspan='1'><u>Top Submitters</u></th><th colspan='1'><u>Numbers of Views</u></th></tr>";
                    
                    while($row = $stmt -> fetch())
                    {
                        $views = $row -> getView();
                        $person = $row -> getName(); 

                        $html = "<tr><th colspan='1'>$person</th><th colspan='1'>$views</th></tr>";

                        echo $html; 

                    }
                }
                catch(SQLException $e)
                {
                    echo "PROBLEM " . $e -> getMessage(); 
                }
            }
            
            
            
           ?>
            </table>
        </div> 

    <div>
        
        
        <footer>               
            <h3> All data © FoodGawker, 2016 </h3>
        </footer>
        


</body

</html>