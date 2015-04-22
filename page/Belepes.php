<?php
// Ha már be voltunk jelentkezve, átirányít a profilra
if (isset($_SESSION['user_id'])){
	if(isset($_SESSION['admin'])){
		header("Location: $admin_home");
		exit;
	}
	else{
		header("Location: $user_home");
		exit;
	}
}

$error ='';
$username = isset($_GET['username']) ? $_GET['username'] : '';
$pass = isset($_GET['code']) ? $_GET['code'] : '';

if ($_POST) {
	/** BIZTONSÁG **/

	$username = htmlspecialchars($mysqli->real_escape_string(trim($_POST['username'])));
	$pass = htmlspecialchars($mysqli->real_escape_string(trim($_POST['pass'])));

	/** ADATBÁZIS OLVASÁS **/

	$sql = sprintf("SELECT id, name, username, admin, email, confirmed 
					FROM users 
					WHERE username = '%s' AND pass = '%s'", $username, sha1($pass));
	$result = $mysqli->query($sql);
	if(!$result)
		$error="Adatbázislekérdezési hiba: $mysqli->error"; //Adatbázislekérdezés ellenőrzés
	else{
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
			if ($row['confirmed'] == 0)
				$error .= "Még nincs jóváhagyva a regisztrációd!<br>";
			else{
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['username'] = $row['username'];  //profil_admin.php oldalon ellenőrzéshez és config/head.php -ban Név kiiratáshoz
				$_SESSION['email'] = $row['email'];        //profil_admin.php oldalon ellenőrzéshez
				if($row['admin'] == 1){
					$_SESSION['admin'] = 1;      
					header("Location: $admin_home");       //Ha admin joga van, adminként lép be
				}
				else header("Location: $user_home");       //Belépés átírányítással a felhasználó kezdőoldalra
				exit;
			}
		}
		else
			$error .= 'HIBA! Rossz felhasználónév vagy jelszó!<br>'; //Hibajelzés, ha nem jó valami adat
	}
}
?>

<div id=content class=center>
<h1>Belépés</h1>
<form class=bigform action="" method="post">

    <p><input type="text" 
	          name="username" 
			  value="<?php echo $username ?>" 
			  placeholder="Felhasználónév" 
			  onClick="this.select();" 
			  autofocus required></p>
	
    <p><input type="password" 
	          name="pass" 
			  value="<?php echo $pass ?>" 
			  placeholder="Jelszó" 
			  onClick="this.select();" 
			  required></p>
	
    <p><button id="button">Belépés</button></p>
	
	<p><a href="Regisztracio/"><u>regisztráció</u></a></p>
	
	<p><span id="error"><?=$error?></span></p>
	
</form>
</div>
