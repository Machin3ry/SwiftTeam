<?php

function crypto_rand_secure($min, $max){
  $range = $max - $min;
  if($range < 1) return $min;
  $log = ceil(log($range, 2));
  $bytes = (int)($log / 8) + 1;
  $bits = (int)$log + 1;
  $filter = (int) (1 << $bits) - 1;
  do {
      $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
      $rnd = $rnd & $filter;
  }while($rnd > $range);
  return $min + $rnd;
}
function getToken($lengh){
  $token = "";
  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
  $codeAlphabet .= "0123456789";
  $max = strlen($codeAlphabet);
  for($i=0; $i < $lengh; $i++){
      $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
  }
  return $token;
}

function form_token($token){
    if (!(isset($token)) OR !(isset($_SESSION['csrf_token'])) OR ($token != $_SESSION['csrf_token'])){
        return false;
    }else{
        return true;
    }
}

function normalize($key, $url, $error){
    if($key === 'error' OR $key === null OR !isset($key)){
      ?><script type="text/javascript">
      window.location="<?php echo $url; ?>";
      </script><?php
        $_SESSION['message'] = $error;
      die();
    }else{
      return trim($key);
    }
}

/**
 * 
 */
class ooooth
{
	
	function __construct()
	{
		# code...
	}

	
	public function check_token($token){
	    $return = form_token($token);
	    if($return == false){
	    $loc='../';
	    ?><script>window.location="<?php echo $loc;?>";</script><?php
	    die();
	    }
	}

	public function remove_tags($html){
	    if(!isset($html)){
	        return 'error';
	    }else{
	        $html = str_replace('<?php' , '', $html);
	        $html = str_replace('?>' , '', $html);
	        $dom = new DOMDocument();
	        $dom->loadHTML($html);
	        $tags_to_remove = array('script','style','iframe','link');
	        foreach ($tags_to_remove as $tag) {
	          $element = $dom->getElementsByTagName($tag);
	          foreach ($element as $item) {
	            $item->parentNode->removeChild($item);
	          }
	        }
	        $clean = $dom->SaveHTML();
	        $clean = str_replace(' ', '', $clean);
	        return  trim($clean);
	    }
	}

	public function filter_string($string){
	    if (!filter_var($string, FILTER_SANITIZE_STRING) === false) {
	      $stirped = strip_tags($string);
	      return trim($stirped);
	    }else{
	      return 'error';
	    }
	}
	public function filter_int($int){
	    $t = strip_tags($int);
	    if (filter_var($t, FILTER_VALIDATE_INT) === 0 OR !filter_var($t, FILTER_VALIDATE_INT) === false) {
	        $stirped = strip_tags($t);
	      return trim((int)$stirped);
	    }else{
	      return 'error';
	    }
	}

	public function stringLength($len,$set){
	    $returnValue = strlen($len);
	    if((int)$returnValue <= $set){
	        return trim($len);
	    }else{
	        return 'error';
	    }
	}
	

	public function authentication_login($password,$username,$mysqli,$pdo){

		$sql=$pdo->prepare("SELECT * FROM hngi_users WHERE swift_username = ? AND  swift_password = ? ");
        $sql->bindParam(1, $username, PDO::PARAM_STR);
        $sql->bindParam(2, $password, PDO::PARAM_STR);
        $sql->execute();

        if (!($sql->rowCount() == 1)){

            $message = "Invalid Username or Password, please kindly sign up now and here";
		   	$msg_u = "error";
		   	$url = "../signup";
		   	$_SESSION['login'] = 404;
			normalize($msg_u, $url, $message); 
        }else{
            $results=$sql->fetch();
            if ($results['swift_username'] == $username AND $results['swift_password'] == $password) {
            	$_SESSION['username'] = $results['swift_username'];
            	$url = "../welcome";
	           	$message = "Welcome, ".$results['swift_firstname']." ".$results['swift_lastname'];
				$_SESSION['login'] = 1;
            }else{
            	$url = "../signup";
            	unset($_SESSION['login']);
            	$message = "Invalid Username or Password, please kindly sign up now and here";
            }
            
	   		$_SESSION['message'] = $message;
			
			?><script type="text/javascript">
	      		window.location="<?php echo $url; ?>";
	      	</script><?php
        }
	}

	public function authentication_signup($firstname,$lastname,$email,$username,$password,$mysqli,$pdo){

		$sql=$pdo->prepare("SELECT * FROM hngi_users WHERE swift_email = ? AND  swift_username = ? ");
        $sql->bindParam(1,   $email, PDO::PARAM_STR);
        $sql->bindParam(2,   $username, PDO::PARAM_STR);
        $sql->execute();

        if (!($sql->rowCount() == 1)){

        	$sql = $pdo->prepare("INSERT  INTO `hngi_users`(`swift_firstname`,`swift_lastname`,`swift_email`,`swift_username`,`swift_password`) VALUES(?,?,?,?,?)");
	        $sql->bindParam(1, $firstname, PDO::PARAM_STR);
	        $sql->bindParam(2, $lastname, PDO::PARAM_INT);
	        $sql->bindParam(3, $email, PDO::PARAM_INT);
	        $sql->bindParam(4, $username, PDO::PARAM_INT);
	        $sql->bindParam(5, $password, PDO::PARAM_INT);
	        if($sql->execute()){
	        	$message = "Sign up was successful, please login";
	        	$url = "../login";
	        }else{
           		$message = "Sign up was not successful, please try again later";
           		$url = "../signup";
	        }
		   	$msg_u = "error";
		   	normalize($msg_u, $url, $message);
        }else{

        	$message = "User with such details exist, please login";
		   	$msg_u = "error";
		   	$url = "../login";
		   	normalize($msg_u, $url, $message);
        }
	}

	public function authentication_reset($hash,$email,$ps,$ps_c,$mysqli,$pdo){
		  
			// Make sure the two passwords match
		    if ( $ps == $ps_c ) { 

		        $new_password = $ps;
		        $new_password_hash = password_hash($ps, PASSWORD_DEFAULT);
		        $sql=$pdo->prepare("SELECT * FROM hngi_users WHERE swift_email = ?");
		        $sql->bindParam(1,   $email, PDO::PARAM_STR);
		        $sql->execute();

		        if (($sql->rowCount() == 1)){
		        	$results=$sql->fetch();
		        	if ($results['swift_hash'] == $hash ) {
				        $sql = "UPDATE hngi_users SET swift_password='$new_password', swift_hash='$hash' WHERE swift_email='$email'";

				        if ( $mysqli->query($sql) ) {

					        $_SESSION['message'] = "Your password has been reset successfully!";
					        $loc="../";
				        }else{
				        	$_SESSION['message'] = " Could Not Complete, please try again";
					        $loc="../";
				        }
			    	}else{
			    		$_SESSION['message'] = "Token Could Not Be Found";
				        $loc="../";
			    	}
		    	}else{
		    		$_SESSION['message'] = "Details Could Not Be Found";
			        $loc="../";
		    	}

		    }
		    else {
		        $_SESSION['message'] = "Password match incorrect, try again!";
		        $loc="../";
		    }
		?><script type="text/javascript">window.location="<?php echo $loc; ?>";</script><?php   
	}

	public function authentication_forgot($email,$mysqli,$pdo){
	    $result = $mysqli->query("SELECT * FROM hngi_users WHERE swift_email='$email'");
	    $count=$result->num_rows;
	    if($count>0) // User do exist
	    { 
	       // User exists (num_rows != 0)

	        $user = $result->fetch_assoc(); // $user becomes array with user data
	        
	        $email = $user['swift_email'];
	        $hash = $new_password_hash = password_hash($user['swift_password'], PASSWORD_DEFAULT);
	        $first_name = $user['swift_firstname'];
	        
	        $sql = "UPDATE hngi_users SET swift_hash='$hash' WHERE swift_email='$email'";
	        $mysqli->query($sql);


	        // Session message to display on success.php
	        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
	        . " for a confirmation link to complete your password reset!</p>";

	        // Send registration confirmation link (reset.php)
	        $to      = $email;
	        $subject = 'Password Reset Link From(HNGI 6.0 - Swift Team)';
	        
	        // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	        $headers .= "To: ".$first_name." <".$email.">"."\r\n";
                $headers .= "Cc: ". $first_name." <".$email.">". "\r\n";
                $headers .= "Bcc: ". $first_name." <".$email ."> "."\r\n";
                $headers .= "Reply-To: ".$email." "."\r\n";
                $headers .= "X-Mailer: PHP/" . phpversion();
              
	        $message_body = '
	        <html>
<head>
  <title>Reset Your Password</title>
</head>
<body>
	        <p>Hello '.$first_name.',

	        You have requested password reset!

	        Please click this link to reset your password:</p>
	        
	        <a href="https://gjengineer.com/SWIFT-TEAM-TEST/recover/index.php?email='.$email.'&hash='.$hash.'" style="padding:5px;background-color:blue;color:white;text-align:center;font-size:20px;">Reset Password</a>
	          </body>
</html>';  

	        mail($to, $subject, $message_body, $headers);

			$loc="../";
			?><script type="text/javascript">
			window.location="<?php echo $loc; ?>";
			</script><?php
	  }else{ 
		   $_SESSION['message'] = "User with that email doesn't exist!";
	        
	        $loc="../../error.php";
			?><script type="text/javascript">
			window.location="<?php echo $loc; ?>";
			</script><?php
	    }
	}
}

?>