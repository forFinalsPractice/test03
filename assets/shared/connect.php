<?php
  $dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$db = "nowuknow"; // this is a mockup outdated database, change the database name according to your updated mockup database or we will use our main database

	$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

	if(!$conn)
	{
		die("Connection Failed. ". mysqli_connect_error());
		echo "can't connect to database";
	}

  function executeQuery($query){
    $conn = $GLOBALS['conn'];
    return mysqli_query($conn, $query);
  }
?>