



<?php

/*
	@author Renuchan Thambirajah, Dimitri Spyropoulos 
*/


getInfoFromAllPages(); 

echo "Done Reading all 100 Pages"; 

function getInfoFromAllPages()
{	
	for($count = 1; $count <= 100; $count++)
	{
		$link = "https://foodgawker.com/page/$count/";
		echo "\n\n********************* Reading $link *********************************************\n\n"; 
		
		$xpath = getXPathPage($link);
		getInfoFromPage($xpath); 
		
		//pause for 1 seconds, to not overflood requests to foodgawker
		sleep(1); 
	}
}

function getXPathPage($url)
{
	$ch = curl_init($url);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$page = curl_exec($ch); 
	curl_close($ch); 
	
	$htmlDom = new DOMDocument(); 
	@$htmlDom -> loadHTML($page); 
	
	$xpath = new DOMXpath($htmlDom);

	return $xpath;	
}

function getInfoFromPage(DOMXpath $xpath)
{
	// a list of all the information required of the current html page
	$allLinks = $xpath -> query("//a[@class='picture-link']/@href");	
	$allTitles = $xpath -> query("//a[@class='picture-link']/@title");	
	$allDes = $xpath -> query("//section[@class='description']");	
	$allPeople = $xpath -> query("//a[@class='submitter']");	
	$allViews = $xpath -> query("//div[@class='gawked']");

	for($i = 0; $i < $allLinks -> length; $i++)
	{
		$title = $allTitles[$i] -> nodeValue ;
		$link = $allLinks[$i] -> nodeValue ;
		$des = $allDes[$i] -> nodeValue ;
		$person = $allPeople[$i] -> nodeValue;
		$view = $allViews[$i] -> nodeValue;
		
		//echo "$title\n$link'n$des\n$person\n$view\n\n\n";
			
		writeToDatabase($title, $link, $des, $person, $view);		
	}		
}

function writeToDatabase($title, $link, $des, $person, $view)
{
	try{
		$dbURL = "mysql:host=localhost;dbname=homestead";
		$username = 'homestead';
		$password = 'secret'; 
		$pdo = new PDO($dbURL, $username, $password);
	
		$query = "INSERT INTO RecipeInfo(name, title, description, link, view) VALUES (?, ?, ?,?,?);"; 
	
		$stmt = $pdo -> prepare($query); 
	
		$stmt -> bindParam(1,$person);
		$stmt -> bindParam(2,$title);
		$stmt -> bindParam(3,$des);
		$stmt -> bindParam(4,$link);
		$stmt -> bindParam(5,$view);
	
		$stmt -> execute(); 
		
		//echo 'inserted entry';
		
	}catch(PDOException $e)
	{}
	finally {
		unset($pdo); 
	}
}

?>