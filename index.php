<?php
	$db = "batid_db";
	$host = "batidlive.mysql.database.azure.com";
	$user = "keithyadmin@batidlive";
	$pass = "Franzlispogi1!";

	$conn = mysqli_init();
	mysqli_real_connect($conn, $host, $user, $pass, $db);

	if (mysqli_connect_errno($conn)) {
		die('Failed to connect to MySQL: '.mysqli_connect_error());
	}
	else {
		echo("Connected successfully!");
	}

	$query = mysqli_query($conn, 'SELECT * FROM reports');
	if (!$query) {
		die('Invalid query: ' . mysql_error());
	}

	$result = mysqli_fetch_assoc($query);

	foreach ($data as $result) {
		echo('<h3>' . $data . '</h3></br>');
	}
?>
