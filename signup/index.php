<?php
session_start();

require '../model/database.php';
require '../controller/functions.php';
require '../controller/constants.php';
require '../controller/error_report.php';

//setting up error[error_reporting,display_errors,display_startup_errors]
// $error_reporting = new error_report(E_ALL,1,1);
$error_reporting = new error_report(0,0,0);
$error_reporting->error();

$page="Sign Up ";

$csrf_token=getToken(120);
$_SESSION['csrf_token'] = $csrf_token;
$_SESSION['signup'] = '';

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
    <p>|</p>
    <a href="../login">Login</a>
    <p>|</p>
    <a href="../signup">SignUp</a>
  </nav>

    <div id="loginPage">
      <div class="row">
        <div class="col-md-12">
          <div class="signup-form">
            <form method="POST" action="../controller/">
             <input type="hidden" name="csrf_field" value="<?php echo $_SESSION['csrf_token']; ?>" class="" id="" />
                    <?php  
                      if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ){
                          $msg=$_SESSION['message'];
                          echo  $msg;
                       }?><?php echo ($_SESSION['message']=""); 
                    ?>
                  <div class="form-group">
                      <div class="imgcontainer">
                          <img src="../assets/images/avatar.png" alt="Avatar" class="avatar" />
                      </div>

                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>
                              <b>Firstname</b>
                            </label>
                            <input   type="text" name="firstname" class="form-control"  placeholder="Enter your Firstname" required/>
                          </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label>
                              <b>Lastname</b>
                            </label>
                            <input  type="text" name="lastname" class="form-control" placeholder="Enter your Lastname" required/>
                        </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>
                          <b>Email</b>
                        </label>
                          <input  type="text" name="email"  class="form-control" placeholder="Enter your Email"  required/>
                      </div>
                    
                      <div class="form-group">
                          <label><b>Username</b></label>
                          <input  type="text" name="username" class="form-control" placeholder="Enter Username"  required/>
                      </div>
                      <div class="form-group">
                          <label><b>Password</b></label>
                          <input type="password"  name="password" class="form-control"  placeholder="Enter Password" required/>
                      </div>
                      
                      <input type="submit" name="signup_user" class="btn btn-lg btn-block" value="Sign up" >

                      <div class="form-group form-check"> 
                        <input type="checkbox" class="form-check-label"/>
                        Remember me
                      </div>
                    </div>
                    <div class="ali">
                      <p>Have an account? <a href="../login"><b>Login</b></a></p>
                    </div>
                </form>
            </div>
        </div>
        </div>
      </div>
    </div>
   <footer class="mainfooter">&copy Copyright 2019 Swift-Team</footer>
    </body>
</html>
