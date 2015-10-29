 <?php
 
	require_once("../../konfig_global.php");
	$database = "if13_rene_p";
	
	//paneme sessiooni k2ima, saame kasutada $_session muutujaid
	session_start();
	
	function createUser($create_email, $password_hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO create_user (username, email, firstname, lastname, tel, amet, password) VALUES (?, ?, ?, ?, ?, 'Talupoeg', ?)");
				
				//asendame ? muutujate v22rtustega
				
				//echo $mysqli->error;
				//echo $stmt->error;
				
				$stmt->bind_param("ssssss",$create_username, $create_email, $create_firstname, $create_lastname, $create_tel, $password_hash);
				$stmt->execute();
				$stmt->close();
				
				$mysqli->close();
		
		
	}

	function loginUser($email, $password_hash){
				$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				$stmt = $mysqli->prepare("SELECT id, username, email, firstname, lastname, tel, amet FROM create_user WHERE email=? AND password=?");
				$stmt->bind_param("ss", $email, $password_hash); //asnendab küsimärgid
				
				//paneme vastused muutujatesse
				
				$stmt->bind_result($id_from_db, $username_from_db, $email_from_db, $firstname_from_db, $lastname_from_db, $tel_from_db, $amet_from_db);
				$stmt->execute();
				echo "<br>";
				
				if($stmt->fetch()){
					
					echo "Kasutaja id=".$id_from_db;
					
					$_SESSION["id_from_db"] = $id_from_db;
					$_SESSION["user_email"] = $email_from_db;
					
					//suunan kasutaja
					
					header("Location: data.php");
					
				}
				else{
					//tühi, ei leidnud
					echo "Wrong password or email";
				}
				$stmt->close();
				$mysqli->close();
		
		
	}

	
 ?>