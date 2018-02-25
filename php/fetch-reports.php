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

	$query = mysqli_query($conn, "SELECT * FROM batid_db.reports");

	if (!$query) {
		die('Invalid query: ' . mysqli_error($conn));
	}

	$all_reports = array();
	while ($report = mysqli_fetch_assoc($query)) {
		// $report refers to an individual row in the table
		array_push($all_reports, array('id'=>$report['id'],
									   'longitude'=>$report['longitude'],
									   'latitude'=>$report['latitude'],
									   'radius'=>$report['radius'],
									   'author'=>$report['author'],
									   'title'=>$report['title'],
									   'content'=>$report['content'],
									   'severity'=>$report['severity'],
									   'upvotes'=>$report['upvotes'],
									   'downvotes'=>$report['downvotes'],
									   'verified'=>$report['verified'],
									   'time_stamp'=>$report['time_stamp']));
	}
	echo json_encode($all_reports);
?>