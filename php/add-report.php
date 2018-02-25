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
	$insert = "INSERT INTO batid_db.reports (longitude, latitude, radius, author, title, content, severity) VALUES ";
	$value = "(".floatval($_POST['lng']).", ".floatval($_POST['lat']).", ".floatval($_POST['radius']).", '".$_POST['author']."', '".$_POST['title']."', '".$_POST['content']."', '".$_POST['severity']."')";
	echo $value;
	$command = $insert . $value;
	
	$query = mysqli_query($conn, $command);
	if (!$query) {
		die('Invalid query: ' . mysqli_error($conn));
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;
?>