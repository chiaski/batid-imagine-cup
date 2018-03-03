<?php
    require_once "php/config.php";
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $email = $password = $confirm_password = "";
        $username_err = $email_err = $password_err = $confirm_password_err = "";
        $pass_limit = 8;

        if(empty(trim($_POST["username"]))) {
            $username_err = "Please enter a username.";
        } 
        else {
            $sql = "SELECT id FROM batid_db.users WHERE username = ?";
            
            if($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = trim($_POST["username"]);
                
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "This username is already taken.";
                    }
                    else {
                        $username = trim($_POST["username"]);
                    }
                }
                else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
        }

        if(empty(trim($_POST["email"]))) {
            $email_err = "Please enter a valid email.";
        }
        else {
            $sql = "SELECT id FROM batid_db.users WHERE email = ?";
            
            if($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                $param_email = trim($_POST["email"]);
                
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1) {
                        $email_err = "This email is already taken.";
                    }
                    else {
                        $email = trim($_POST["email"]);
                    }
                }
                else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
        }
        
        if(empty(trim($_POST['password']))) {
            $password_err = "Please enter a password.";  
        } 
        elseif(strlen(trim($_POST['password'])) < $pass_limit) {
            $password_err = "Password must have atleast ".$pass_limit." characters.";
        } 
        else {
            $password = trim($_POST['password']);
        }
        
        if(empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = 'Please confirm password.';  
        } 
        else {
            $confirm_password = trim($_POST['confirm_password']);
            if($password != $confirm_password) {
                $confirm_password_err = 'Password did not match.';
            }
        }
        
        if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
            $sql = "INSERT INTO batid_db.users (username, email, password) VALUES (?, ?, ?)";
             
            if($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
                
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                
                if(!mysqli_stmt_execute($stmt)) {
                    echo "Something went wrong. Please try again later.";
                }
                else {
                    $_SESSION['username'] = $username;
                    header("location: index.php");
                }
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }
?>

<html>
	<head>
		<title>Batid - Registration</title>
	</head>

	<body>
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    

            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
	</body>
</html>