<?php
	
	session_start();
	include "config.php";

	try { // connect to DB
	  $host = $config["DB_HOST"];
	  $dbname = $config["DB_NAME"];
	  $user = $config["DB_USERNAME"];
	  $pass = $config["DB_PASSWORD"];
	  $dbconn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);
	}
	catch (Exception $e) {
	  echo "Error: " . $e->getMessage();
	}

	//stroe post data to vars
	$listName = $_POST['listName'];
	$itemName = $_POST['itemName'];
	$attrName = $_POST['attrName'];

	$sql = "CREATE TABLE IF NOT EXISTS `$listName` (
	`$itemName` varchar(255) NOT NULL,
	userid int,
	FOREIGN KEY (userid) REFERENCES users(userid)
	)";
	$dbconn->exec($sql); //create table that user made

	$stmt = $dbconn->prepare("INSERT INTO $listName ($itemName, userid) VALUES (:$itemName, :userid)");
  $stmt->execute(array(":$itemName" => $attrName, ":userid" => $_SESSION['userid'])) or die("nope"); //insert user data into table

  echo "Stored to DB!";

  header("Location: ../../main_page.php");

?>