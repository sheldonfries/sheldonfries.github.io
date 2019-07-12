<?php

	$server = "sql206.byethost7.com";
	$db = "b7_18329451_calc";
	$username = "b7_18329451";
	$password = "bieksa4mvp";
	$conn = mysqli_connect($server, $username, $password, $db);
	
	if($conn->connect_error)
	{
		echo "Failed to connect.";
	}

	$rows = $conn->query("SELECT * from goalies");

?>