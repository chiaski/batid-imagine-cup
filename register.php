<!doctype html>
<html lang="">
    <head>
        <title>Batid - Make an Account</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/report.css">
        <link rel="stylesheet" href="css/etc.css">

        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        
        <script src="js/fetch.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.js"><\/script>')</script>

    
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css"/>
        <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
    </head>

    <body>   
        
        
    <div id="batid-header">
        <center>
            <button class="header-button" href="index.php"><i class="fas fa-map"></i><br />Map</button>
            <button class="header-button" href="login.php"><i class="fas fa-user"></i><br />Account</button>
        </center>
    </div>
        
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
        
    <div id="container" style="width:976px;">
        <div class="content content-login" style="margin: auto; height:500px; background: 0; padding: 5em 1em 1em 1em">
        <center>
            <div class="login-tlogin">
        <h1>Create an Account</h1>
        <p>Ready to impact the world? Create a Batid account to begin reporting incidents, voting, and contributing to the fastest growing collective of citizen news.<br />Need any help? Contact us at batidph@gmail.com.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-etc">
            
            <left>
            <table>
            <tr>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <td style="width:150px;">
                <label for="inpute1">Username</label></td>    
                <td style="width:350px;">
                <input type="text" name="username" value="<?php echo $username; ?>" id="inpute1" class="input-name">
                <span class="help-block"><?php echo $username_err; ?></span>
                </td>
            </div>  
            </tr> 
            <tr>
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">  
                <td style="width:150px;">
                <label for="inpute2">Email</label></td> 
                <td style="width:350px;">
                    <input type="text" id="inpute2" name="email" class="input-email" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </td>
                </div>
            </tr>
            <tr>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <td style="width:150px;"><label for="inputp1">Password <i class="fas fa-exclamation-circle" title="At least 8 characters."></i></label></td>
                <td style="width:350px;">
                <input type="password" name="password" class="input-pass" id="inputp1" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span></td>
            </div>
            </tr>
            <tr>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <td style="width:150px;"><label for="inputp2">Confirm Password</label></td>
                <td style="width:350px;">
                <input type="password" name="confirm_password" class="input-pass" id="inputp2" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span></td>
            </div>
            </tr>
                
            </table>
                
        
            <div class="form-group">
                <input type="submit" class="btn btn-submit" value="Login">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
                
        </form>
                
            </div>
            
        </center>
            
        </div>
    </div>
    
        
        
        <script type="text/javascript" src="js/function.js"></script>
        <script type="text/javascript" src="js/mainlogin.js"></script>
    </body>
</html>
e