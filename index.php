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
	else {
		echo("Connected successfully!\n");
	}

	$query = mysqli_query($conn, "SELECT * FROM batid_db.reports");

	if (!$query) {
		die('Invalid query: ' . mysqli_error($conn));
	}

	while ($result = mysqli_fetch_assoc($query)) {
		echo "<tr>";
			echo "<td>" . $result['longitude'] . "</td>";
			echo "<td>" . $result['latitude'] . "</td>";
			echo "<td>" . $result['radius'] . "</td>";
			echo "<td>" . $result['author'] . "</td>";
			echo "<td>" . $result['title'] . "</td>";
			echo "<td>" . $result['content'] . "</td>";
			echo "<td>" . $result['severity'] . "</td>";
			echo "<td>" . $result['upvotes'] . "</td>";
			echo "<td>" . $result['downvotes'] . "</td>";
		echo "</tr>";
	}
?>
