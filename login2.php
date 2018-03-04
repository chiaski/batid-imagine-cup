<?php
    require_once "php/config.php";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = "";
        $password = "";
        $error = "";
        $_POST['username'] = mysqli_real_escape_string($conn, $_POST['username']);
        $_POST['password'] = mysqli_real_escape_string($conn, $_POST['password']);

        if(empty(trim($_POST["username"]))){
            $error = 'Please enter username.';
        }
        else {
            $username = trim($_POST["username"]);
        }

        if(empty(trim($_POST['password']))){
            $error = 'Please enter your password.';
        }
        else {
            $password = trim($_POST['password']);
        }

        if(empty($error)){
            $sql = "SELECT * FROM batid_db.users WHERE username='" . $username . "' AND password='" . $password . "'";
            $query = mysqli_query($conn, $sql);
            if (!(mysqli_num_rows($query) == 0)) {
              if(session_id() == '' || !isset($_SESSION)) {
                // session isn't started
                session_start();
              }
              $_SESSION['username'] = $username;
              header("location: index.php");
            } else {
            
            }
            mysqli_close($conn);
         }
        }
?>

<html>
    <head>
        <title>Batid - Login</title>
    </head>

    <body>
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
             <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </body>
</html>
