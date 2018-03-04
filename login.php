<!doctype html>
<html lang="">
    <head>
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
            <button class="header-button" onclick="viewFeed();"><i class="fas fa-list"></i><br />View Feed</button>
            <button class="header-button" onclick="addReport();"><i class="fas fa-pencil-alt"></i><br />Add Report</button>
        </center>
        <div class="header-icon"><img src="https://i.imgur.com/MB30klE.png" /></div>
    </div>
        
    <div class="batid-dropdown">
        <a>Home</a>
        <a>Map</a>
        <a>Feed</a>
        <a>Account</a>
        <a>Settings</a>
        <a style="color:#ddd;">Log Out</a>
    </div>
    
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
        
    <div id="container" style="width:976px;">
        <div class="content content-login" style="margin: auto; height:500px; background: 0; padding:1em;">
        <center>
            <div class="login-tlogin">
        <h1>Login</h1>
        <p>Login with your Batid account details.<br />Need any help? Contact us at batidph@gmail.com.</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-etc">
            
            <left>
            <table>
            <tr>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <td style="width:150px;">
                <label for="inpute1">Email</label></td>    
                <td style="width:350px;"><input type="text" name="username" id="inpute1" class="input-email" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span></td>
            </div>  
            </tr>  
            <tr>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <td style="width:150px;"><label for="inputp1">Password</label></td>
                <td style="width:350px;">
                <input type="password" name="password" class="input-pass" id="inputp1">
                <span class="help-block"><?php echo $password_err; ?></span></td>
            </div>
            </tr>
                
            </table>
                
        
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
             <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
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