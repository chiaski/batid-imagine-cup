<?php
    require_once "php/config.php";
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = "";
        $password = "";
        $error = "";

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
            $sql = "SELECT username, password FROM batid_db.users WHERE username = ?";
            
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;
                
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                        
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                session_start();
                                $_SESSION['username'] = $username;
                                header("location: index.php");
                            } 
                            else {
                                $error = 'Either your username or password is incorrect.';
                            }
                        }
                    } 
                    else {
                        $error = 'Either your username or password is incorrect.';
                    }
                } 
                else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }
?>

<html>
    <head>
        <title>Batid - Login</title>
    </head>

    <body>
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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