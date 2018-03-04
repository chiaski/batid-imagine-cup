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
        <script src="js/fetch.js"></script>
        <script src="js/upvote-downvote.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>
	</head>

	<body>
		<div id="report-container">
			<h1 id="report-title"></h1>
			<p id="report-content"></h1>
		</div>

		<form action="php/add-comment.php" method='post'>
			<textarea name='content' placeholder="Add a comment."></textarea>
			<input type='hidden' name='post_id' value='<?php echo htmlspecialchars($id); ?>'/>
			<input type='hidden' name='author' value='<?php echo htmlspecialchars($author); ?>'/>
			<input type="submit"/>
		</form>

		<script>
			var id = '<?php echo htmlspecialchars($id); ?>';

	        function updateForever() {
                fetchReports();
                fetchComments();
                fetchMultimedia();

                for(var i = 0; i < all_reports.length; i++) {
                    if(all_reports[i].id == id) {
                    	$('.report-title').text(all_reports[i].title);
                    	$('.report-content').text(all_reports[i].content);
                    }
                }
                all_markers.addTo(batid);
                var repeater = window.setTimeout(updateForever, 1000);
            }
            updateForever();
		</script>

		<script src="js/main.js"></script>
	</body>
</html>
