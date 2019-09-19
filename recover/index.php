<?php

session_start();

require '../model/database.php';
require '../controller/functions.php';
require '../controller/constants.php';

require '../controller/error_report.php';
//setting up error[error_reporting,display_errors,display_startup_errors]
$error_reporting = new error_report(E_ALL,1,1);
// $error_reporting = new error_report(0,0,0);
$error_reporting->error();

$page="Reset ";

$csrf_token=getToken(120);
$_SESSION['csrf_token'] = $csrf_token;
$ooth_key = new ooooth();
// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
         $url = "../";
        $error = "Your email is incorrect";
	    $sanitize_1= $ooth_key->remove_tags($_GET['email']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $email= $ooth_key->stringLength($sanitize_2,50); normalize($email, $url, $error);

        $error = "Your url is incorrect";
	    $sanitize_1= $ooth_key->remove_tags($_GET['hash']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $hash= $ooth_key->stringLength($sanitize_2,250); normalize($hash, $url, $error);


    // Make sure user email with matching hash exist
    $result = $mysqli->query("SELECT * FROM hngi_users WHERE swift_email='$email' AND swift_hash='$hash'");

    if ( $result->num_rows == 0 )
    { 
        $_SESSION['message'] = "You have entered invalid URL for password reset!";
        $loc="../login";
    ?><script type="text/javascript">window.location="<?php echo $loc; ?>";</script><?php
    }
}
else {
    $_SESSION['message'] = "Sorry, verification failed, try again!";
    $loc="../login";
    ?><script type="text/javascript">window.location="<?php echo $loc; ?>";</script><?php  
}

$page=" Reset Your Password";

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
<body style="background-image: url('../assets/images/chi.jpg');" >
  <header class="mainheader">SWIFT TEAM</header>
  <nav class="navbar1">
    <a href="">Home</a>
    <p>|</p>
    <a href="login">Login</a>
    <p>|</p>
    <a href="signup">SignUp</a>
  </nav>


<div class="subcontainer" style="height: 100% !important;">
  <p class="welcome"> Choose Your New Password</p>
  <form method="post" action="../controller/">
    <input type="hidden" name="csrf_field" value="<?php echo $_SESSION['csrf_token']; ?>" class="csrf_field" id="" />

    <div class="row collapse">
      <div class="small-10  columns">
      <label>
      New Password<span class="req">*</span>
      </label>
      <input type="password"required name="newpassword" autocomplete="off"/>
      </div>
    </div>
    <div class="row collapse">

    <div class="small-10 columns ">
      <label>
      Confirm New Password<span class="req">*</span>
      </label>
      <input type="password"required name="confirmpassword" autocomplete="off"/>
      </div>
    </div>

    <!-- This input field is needed, to get the email of the user -->
    <input type="hidden" name="email" value="<?php echo $email; ?>">    
    <input type="hidden" name="hash" value="<?php echo $hash; ?>"> 
    <button  type="submit" name="submitreset"  class="btn btn-lg btn-block">Update Password</button>

  </form>
</div>
  <footer class="mainfooter">&copy Copyright 2019 Swift-Team</footer>
</body>
</html>
