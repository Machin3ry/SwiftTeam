<?php

session_start();
require 'error_report.php';
//setting up error[error_reporting,display_errors,display_startup_errors]
// $error_reporting = new error_report(E_ALL,1,1);
$error_reporting = new error_report(0,0,0);
$error_reporting->error();
date_default_timezone_set('Africa/Lagos');
require '../model/database.php';
require 'functions.php';

$ooth_key = new ooooth();

	if (isset($_POST['login_user'])) {
		

	    $ooth_key->check_token($_POST['csrf_field']);


	    $_SESSION['login'] = '';


	    $url='../login';
	    $error = "Your username is incorrect";

	    $sanitize_1= $ooth_key->remove_tags($_POST['username']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $username= $ooth_key->stringLength($sanitize_2,50); normalize($username, $url, $error);

	    $error = "Your Password is incorrect";
	    $sanitize_1= $ooth_key->remove_tags($_POST['password']);$sanitize_2= $ooth_key->filter_string($sanitize_1);  $password= $ooth_key->stringLength($sanitize_2,50); normalize($password, $url, $error);


	    $ooth_key->authentication_login($password,$username,$mysqli,$pdo);
	}
	elseif(isset($_POST['signup_user'])){
		
		$ooth_key->check_token($_POST['csrf_field']);

		$_SESSION['signup'] = '';

	    $url='../signup';

	    $error = "Your firstname is incorrect";
	    $sanitize_1= $ooth_key->remove_tags($_POST['firstname']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $firstname= $ooth_key->stringLength($sanitize_2,50); normalize($firstname, $url, $error);

	    $error = "Your lastname is incorrect";
	    $sanitize_1= $ooth_key->remove_tags($_POST['lastname']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $lastname= $ooth_key->stringLength($sanitize_2,50); normalize($lastname, $url, $error);

	    $error = "Your email is incorrect";
	    $sanitize_1= $ooth_key->remove_tags($_POST['email']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $email= $ooth_key->stringLength($sanitize_2,50); normalize($email, $url, $error);

	    $error = "Your username is incorrect";
	    $sanitize_1= $ooth_key->remove_tags($_POST['username']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $username= $ooth_key->stringLength($sanitize_2,50); normalize($username, $url, $error);

	    $error = "Your Password is incorrect";
	    $sanitize_1= $ooth_key->remove_tags($_POST['password']);$sanitize_2= $ooth_key->filter_string($sanitize_1);  $password= $ooth_key->stringLength($sanitize_2,50); normalize($password, $url, $error);

	    $ooth_key->authentication_signup($firstname,$lastname,$email,$username,$password,$mysqli,$pdo);
	    

	}elseif(isset($_POST['submitreset'])){

	    $ooth_key->check_token($_POST['csrf_field']); 
		// Make sure the form is being submitted with method="post"
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// We get $_POST['email'] and $_POST['hash'] from the hidden input field of reset.php form
	        $error = "Your email is incorrect";
	    	$sanitize_1= $ooth_key->remove_tags($_POST['email']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $email= $ooth_key->stringLength($sanitize_2,50); normalize($email, $url, $error);
	        $error = "Your Url is incorrect";
	    	$sanitize_1= $ooth_key->remove_tags($_POST['hash']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $hash= $ooth_key->stringLength($sanitize_2,250); normalize($hash, $url, $error);
	    	$error = "Your newpassword is incorrect";
	    	$sanitize_1= $ooth_key->remove_tags($_POST['newpassword']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $newpassword= $ooth_key->stringLength($sanitize_2,50); normalize($newpassword, $url, $error);
	    	$error = "Your confirmpassword is incorrect";
	    	$sanitize_1= $ooth_key->remove_tags($_POST['confirmpassword']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $confirmpassword= $ooth_key->stringLength($sanitize_2,50); normalize($confirmpassword, $url, $error);

	    	$ooth_key->authentication_reset($hash,$email,$newpassword,$confirmpassword,$mysqli,$pdo);
		    
		}else{
		    $loc="../";
		    ?><script type="text/javascript">window.location="<?php echo $loc; ?>";</script><?php

		}
	}elseif(isset($_POST['submitforgot'])){
		 $ooth_key->check_token($_POST['csrf_field']); 
		// Make sure the form is being submitted with method="post"
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// We get $_POST['email'] and $_POST['hash'] from the hidden input field of reset.php form
	        $error = "Your email is incorrect";
	    	$sanitize_1= $ooth_key->remove_tags($_POST['email']);$sanitize_2= $ooth_key->filter_string($sanitize_1); $email= $ooth_key->stringLength($sanitize_2,50); normalize($email, $url, $error);
	    	$ooth_key->authentication_forgot($email, $mysqli, $pdo);
	    	
	    }else{
		    $loc="../";
		    ?><script type="text/javascript">window.location="<?php echo $loc; ?>";</script><?php

		}
	}else{
		header("location:../");
	}


?>