<?php
 	
	$host  = 'localhost';
	$user = 'root';
	$pass='';
	
        
	$dbE='friendsc_swift_team';
	$link = new mysqli($host,$user,$pass);
	if (!$link) {
		die('Could not connect: ' . mysqli_error($link));
	}
	$db_selected = mysqli_select_db($link, $dbE);
	if ($db_selected) {
	
	$db=$dbE;
	$charset = 'utf8mb4';
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false, 
		];
		try {
			$pdo = new PDO($dsn, $user, $pass, $options);
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
			
		}

		$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
	}else{
		$sql= "CREATE DATABASE $dbE";
		if (mysqli_query($link, $sql)) {
			$db=$dbE;
			$charset = 'utf8mb4';
			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false, 
				];
					try {
						$pdo = new PDO($dsn, $user, $pass, $options);
					} catch (\PDOException $e) {
						throw new \PDOException($e->getMessage(), (int)$e->getCode());
						
					}
					

			$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
			$_SESSION['mysqli']=$mysqli;
			$fp = fopen("model/structure.sql", 'rb');
	        $sql = file_get_contents("model/structure.sql");
			if ($mysqli->multi_query($sql)) {?>
				<script type="text/javascript">
					window.location('');
				</script>
				<?php

	        } else {
	           die('Could Not Seed new databse: ' . mysqli_error($link));
	        }
		}else{
			die('Database not Found and could not Create new databse: ' . mysqli_error($link));
		}
	}

?>
