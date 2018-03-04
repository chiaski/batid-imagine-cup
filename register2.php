<?php
    require_once "php/config.php";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $email = $password = $confirm_password = "";
        $username_err = $email_err = $password_err = $confirm_password_err = "";
        $pass_limit = 8;

        $_POST['username'] = mysqli_real_escape_string($conn, $_POST['username']);
        $_POST['email'] = mysqli_real_escape_string($conn, $_POST['email']);
        $_POST['password'] = mysqli_real_escape_string($conn, $_POST['password']);

        if(empty(trim($_POST["username"]))) {
            $username_err = "Please enter a username.";
        } else {
            $sql = "SELECT * FROM batid_db.users WHERE username='" . trim($_POST["username"] . "'");
            $query = mysqli_query($conn,$sql);
            if (mysqli_num_rows($query)>0) {
              $username_err = 'Username already taken';
            } else {
              $username = trim($_POST["username"]);
            }
        }

        if(empty(trim($_POST["email"]))) {
            $email_err = "Please enter a valid email.";
        }
        else {
            $sql = "SELECT * FROM batid_db.users WHERE email='" . trim($_POST["email"] . "'");
            $query = mysqli_query($conn,$sql);
            if (mysqli_num_rows($query)>0) {
              $email_err = 'Email already in use';
            } else {
              $email = trim($_POST["email"]);
            }
        }

        if(empty(trim($_POST['password']))) {
            $password_err = "Please enter a password.";
        } else if(strlen(trim($_POST['password'])) < $pass_limit) {
            $password_err = "Password must have atleast ".$pass_limit." characters.";
        } else {
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
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO batid_db.users (username, email, password) VALUES ('".$username."','".$email."','".$password."')";
            $query = mysqli_query($conn,$sql);
            if(!$query) {
              echo "Something went wrong. Please try again later. " . $username . ' ' . $password . ' ' . $email . '</br> Error Message:' . mysqli_error($conn);
            } else {
              if(session_id() == '' || !isset($_SESSION)) {
                // session isn't started
                session_start();
              }
              $_SESSION['username'] = $username;
              header("location: index.php");
            }
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
