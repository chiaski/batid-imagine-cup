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

	$query = mysqli_query($conn, "SELECT * FROM batid_db.comments");

	if (!$query) {
		die('Invalid query: ' . mysqli_error($conn));
	}

	$all_comments = array();
	while ($report = mysqli_fetch_assoc($query)) {
		// $report refers to an individual row in the table
		array_push($all_comments, array('id'=>$report['post_id'],
										'author'=>$report['author'],
										'content'=>$report['content'],
										'upvotes'=>$report['upvotes'],
										'downvotes'=>$report['downvotes'],
										'time_stamp'=>$report['time_stamp']));
	}
	echo json_encode($all_comments);
?>