<?php
	require_once "config.php";

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