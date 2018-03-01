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

	$username = $password = $confirm_password = "";
	$username_err = $password_err = $confirm_password_err = "";
	 
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty(trim($_POST["username"]))) {
			$username_err = "Please enter a username.";
		} else{
			$sql = "SELECT id FROM users WHERE username = ?";
			
			if($stmt = mysqli_prepare($conn, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				
				$param_username = trim($_POST["username"]);
				
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					
					if(mysqli_stmt_num_rows($stmt) == 1){
						$username_err = "This username is already taken.";
					} else{
						$username = trim($_POST["username"]);
					}
				} else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}
			mysqli_stmt_close($stmt);
		}
		
		if(empty(trim($_POST['password']))){
			$password_err = "Please enter a password.";  
		} elseif(strlen(trim($_POST['password'])) < 8){
			$password_err = "Password must have atleast 8 characters.";
		} else{
			$password = trim($_POST['password']);
		}
		
		if(empty(trim($_POST["confirm_password"]))){
			$confirm_password_err = 'Please confirm password.';  
		} else{
			$confirm_password = trim($_POST['confirm_password']);
			if($password != $confirm_password){
				$confirm_password_err = 'Password did not match.';
			}
		}
		
		if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
			$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
			 
			if($stmt = mysqli_prepare($conn, $sql)){
				mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
				
				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
				
				if(mysqli_stmt_execute($stmt)){
					header("location: login.php");
				} else{
					echo "Something went wrong. Please try again later.";
				}
			}
			mysqli_stmt_close($stmt);
		}
		mysqli_close($conn);
	}
?>