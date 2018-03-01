<?php
	$db = "batid_db";
	$host = "batidlive.mysql.database.azure.com";
	$user = "keithyadmin@batidlive";
	$pass = "Franzlispogi1!";

	$conn = mysqli_init();
	mysqli_real_connect($conn, $host, $user, $pass);
	
	if (mysqli_connect_errno($conn)) {
		die('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
?>