<?php
	require_once "config.php";

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
									   'multimedia'=>$report['multimedia'],
									   'time_stamp'=>$report['time_stamp']));
	}
	echo json_encode($all_reports);
?>