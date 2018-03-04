<?php	
	if(session_id() == '' || !isset($_SESSION)) {
		session_start();
		$author = $_SESSION['username'];
	}
	else {
		$author = "no-user";
	}
  
	$id = $_GET['id'];
  if(empty($id)) {
    header("location: index.php");
  }
?>

<html>
	<head>
		<title>Batid - Permalink</title>
	</head>

	<body>
		<form action="php/add-comment.php" method='post'>
			<textarea name='content' placeholder="Add a comment."></textarea>
			<input type='hidden' name='post_id' value='<?php echo htmlspecialchars($id); ?>'/>
			<input type='hidden' name='author' value='<?php echo htmlspecialchars($author); ?>'/>
			<input type="submit"/>
		</form>
	</body>
</html>
