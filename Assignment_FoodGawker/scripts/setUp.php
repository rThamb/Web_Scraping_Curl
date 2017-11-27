 <?php
 
setUp();
 
function setUp()
{
    try{
		$pdo = new PDO('mysql:host=localhost;dbname=homestead','homestead','secret');
		$dropRecipeInfo = 'DROP TABLE IF EXISTS RecipeInfo';
		$pdo ->exec($dropRecipeInfo);
		$createRecipeInfo = 'CREATE TABLE RecipeInfo(
							id int(4) AUTO_INCREMENT,
							name varchar(255),
							title varchar(255),
							description varchar(255),
							link varchar(255),
							view int(4) DEFAULT 0,PRIMARY KEY (id));';
		$pdo ->exec($createRecipeInfo);
		
		echo 'Database created.';
	   
    }catch(PDOException $e){
        echo $e ->getMessage();
    }
    finally{
        unset($pdo);
    }
}
?>