<?php
// success
session_start();
if ($_SESSION['login'] != 1) {
	header("location:../");
}


require '../model/database.php';
require '../controller/functions.php';
require '../controller/constants.php';
require '../controller/error_report.php';

//setting up error[error_reporting,display_errors,display_startup_errors]
// $error_reporting = new error_report(E_ALL,1,1);
$error_reporting = new error_report(0,0,0);
$error_reporting->error();

$page="Welcome ";

$csrf_token=getToken(120);
$_SESSION['csrf_token'] = $csrf_token;

?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
        <title><?php echo title." | ".$page;?></title>
    <link rel="shortcut icon" href="<?php echo logo;?>" />
  </head>
  <body style="background-image: url('../assets/images/chi.jpg');">
    <header class="mainheader">SWIFT TEAM</header>
  <nav class="navbar1">
    <a href="../">Home</a>
    <div style="float: right;"><?php echo "Hi, ".$_SESSION['username']; ?><p>|</p>
    	<a href="../logout" style="float: right;">Logout</a>
    </div>

    
  </nav>

    <div id="loginPage" style="height:100% !important;">
      <div class="row">
        <div class="col-md-12">
          <div class="signup-form">
                    <?php  
                      if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ){
                          $msg=$_SESSION['message'];
                          echo  $msg;
                       }?><?php echo ($_SESSION['message']=""); 
                    ?>
                </form>
            </div>
        </div>
        </div>
      </div>
    </div>
   <footer class="mainfooter">&copy Copyright 2019 Swift-Team</footer>
    </body>
</html>
