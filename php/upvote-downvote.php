<?php
	require_once "config.php";
	
	if ($_POST['mode'] == 'upvote') {
	    $insert = "UPDATE batid_db.reports SET upvotes = upvotes + 1 WHERE id = '" . $_POST['id'] . "'"; 
	} else if ($_POST['mode'] == 'downvote') {
	    $insert = "UPDATE batid_db.reports SET downvotes = downvotes + 1 WHERE id = '" . $_POST['id'] . "'"; 
	}
	
	$query = mysqli_query($conn, $insert);
	if (!$query) {
		die('Invalid query: ' . mysqli_error($conn));
	}
	
	exit;
?>
