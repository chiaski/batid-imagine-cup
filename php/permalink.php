<?php
  require_once "config.php";
  $id = $_GET['id'];
  $sqlstr = "SELECT * FROM batid_db.reports WHERE id=" . $id;
  $query = mysqli_query($conn, $sqlstr);

  if (!$query) {
      die('Invalid query: ' . mysqli_error($conn));
  }

  $report = mysqli_fetch_assoc($query);
  foreach ($report as $key => $value) {
      echo $key . ': ' . $value . ' </br>';
  }
?>
