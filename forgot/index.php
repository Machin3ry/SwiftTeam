<?php

session_unset();
session_start();

require '../model/database.php';
require '../controller/functions.php';
require '../controller/constants.php';
require '../controller/error_report.php';

//setting up error[error_reporting,display_errors,display_startup_errors]
// $error_reporting = new error_report(E_ALL,1,1);
$error_reporting = new error_report(0,0,0);
$error_reporting->error();

$page="Forgot Password ";

$csrf_token=getToken(120);
$_SESSION['csrf_token'] = $csrf_token;
$_SESSION['login'] = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
        <title><?php echo title." | ".$page;?></title>
    <link rel="shortcut icon" href="<?php echo logo;?>" />
</head>
<body style="background-image: url('../assets/images/chi.jpg');">
	<header class="mainheader">SWIFT TEAM</header>
	<nav class="navbar1">
		<a href="../">Home</a>
		<p>|</p>
		<a href="../login">Login</a>
		<p>|</p>
		<a href="../signup">SignUp</a>
	</nav>
    <div class="subcontainer">
    	<?php  
                      if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ){
                          $msg=$_SESSION['message'];
                          echo  $msg;
                       }?><?php echo ($_SESSION['message']=""); 
                    ?>
    	<section>
		    <h1>Forgot Password</h1>

		 <form method="POST" action="../controller/">
		 	 <input type="hidden" name="csrf_field" value="<?php echo $_SESSION['csrf_token']; ?>" class="" id="" />
		    	<label>Email</label>
		    	<input type="email" autocomplete="off"  name="email"  required />
		    	<input type="submit" name="submitforgot" value="Reset">
		    </form>
		    <!-- <a href="../forgot" class="forgot">Forgot Password?</a> -->
    	</section>
    	<section class="underbar">
		    <h5>Login Using</h5>
		    <div class="space">
		    <a href="#"><img src="../assets/images/go.svg"></a>
		    <a href="#"><img src="../assets/images/fb.png"></a>
			</div>
		    <p>Don't have an account? <a href="../signup">Sign Up</a></p>
		</section>
	</div>
	
	<footer class="mainfooter">&copy Copyright 2019 Swift-Team</footer>
</body>
</html>