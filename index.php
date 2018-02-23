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
		die('Invalid query: ' . mysqli_error($conn));
	}
	$result = mysqli_fetch_assoc($query);
	?>
	<html>
		<head>
			<title>
				Batid
			</title>
		</head>
		<body>
			<table>

<?php
	while ($result = mysqli_fetch_assoc($query)) {
		echo "<tr>";
			echo "<td>" . $row['longitude'] . "</td>";
			echo "<td>" . $row['latitude'] . "</td>";
			echo "<td>" . $row['radius'] . "</td>";
			echo "<td>" . $row['author'] . "</td>";
			echo "<td>" . $row['title'] . "</td>";
			echo "<td>" . $row['content'] . "</td>";
			echo "<td>" . $row['severity'] . "</td>";
			echo "<td>" . $row['upvotes'] . "</td>";
			echo "<td>" . $row['downvotes'] . "</td>";
		echo "</tr>";
	}
?>
		</body>
