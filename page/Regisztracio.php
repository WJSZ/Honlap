<?php 
/** VÁLTOZÓK DEKLARÁLÁSA **/

$error =''; 
$username = isset($_GET['username']) ? $_GET['username'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';

if ($_POST) {
	/** BIZTONSÁG **/

	$name = htmlspecialchars($mysqli->real_escape_string(trim($_POST['name'])));
	$username = htmlspecialchars($mysqli->real_escape_string(trim($_POST['username'])));
	$email  = htmlspecialchars($mysqli->real_escape_string(trim($_POST['email'])));
	$pass = htmlspecialchars($mysqli->real_escape_string(trim($_POST['pass'])));
	$pass2 = htmlspecialchars($mysqli->real_escape_string(trim($_POST['pass2'])));

	/** ELLENŐRZÉSEK **/

	if($name == '' ) { $error .= 'HIBA! Hiányzik a név!<br>';}
	if($username == '' ) { $error .= 'HIBA! Hiányzik a felhasználónév!<br>';}
	if($email == '' ) { $error .= 'HIBA! Hiányzik az email cím!<br>';}
	if($pass == '' ) { $error .= 'HIBA! Hiányzik a jelszó!<br>';}
	if($pass2 == '' ) { $error .= 'HIBA! Hiányzik a jelszó ismétlés!<br>';}
	if (strlen($pass) < 7){ $error .= 'HIBA! A jelszó túl rövid!<br>';}
	if ($pass!=$pass2){ $error .= 'HIBA! Nem egyezik a két jelszó!<br>';} 

	$sql = sprintf("SELECT * FROM users WHERE username = '%s' ", $username); //Vizsgálat: van-e ilyen felh.név
	$mysqli->query($sql);
	if($mysqli->affected_rows > 0){ $error .= 'HIBA! Már létezik ilyen felhasználónév!<br>';}

	$sql = sprintf("SELECT * FROM users WHERE email = '%s' ", $email); //Vizsgálat: van-e ilyen e-mail
	$mysqli->query($sql);
	if($mysqli->affected_rows > 0){ $error .= 'HIBA! Már regisztráltak ezzel az e-mail címmel!<br>';}

	if(valid_email($email) == false) { $error .= 'HIBA! Érvénytelen e-mail cím!<br>';}

	/** ADATBÁZIS ÍRÁS **/

	if($error == ''){
		$sql = sprintf("INSERT INTO users SET name = '%s', username = '%s', email='%s', pass = '%s'", $name, $username, $email, sha1($pass));
		$mysqli->query($sql);
		$mysqli->close();
		$done=1; //Ha sikerült az adatbázis írás, akkor a változónak értéket ad
	}
}
?> 

<div id="content">
		
<h1>Regisztráció</h1>

<form class="bigform center" method="post" action="">

	<?php if (!isset($done)) : ?> <!-- Ha még nem volt adatbázisba írás akkor az endif-ig lévő jelenik meg-->
	 <p>(Minden mező megadása kötelező)</p>
	 
     <p><input name="name"  
	           value="<?php echo $name ?>"
			   placeholder="Teljes Név" 
			   onClick="this.select();" 
			   autocomplete="off" required autofocus/></p>
	 
	 <p><input name="username" 
	           value="<?php echo $username ?>" 
			   placeholder="Felhasználónév" 
			   onClick="this.select();" 
			   autocomplete="off" required/></p>
	 
	 <p><input type="email" 
	           value="<?php echo $email ?>" 
			   name="email" 
			   placeholder="Email" 
			   onClick="this.select();" 
			   required></p>
	 
     <p><input type="password" 
	           name="pass" 
			   placeholder="Jelszó (min 7 karakter)" 
			   onClick="this.select();" 
			   autocomplete="off" required/></p>
	 
	 <p><input type="password" 
	           name="pass2" 
			   placeholder="Jelszó ismét" 
			   onClick="this.select();" 
			   autocomplete="off" required/></p>
	 
     <p><button id="button">Regisztráció</button></p>
	<?php endif ?>
	
	<?php if (isset($done)) : ?><p>A regisztráció sikeres, amint jóváhagytuk értesítünk e-mailben!</p>
	<?php 
	/* email értesítés a regisztrációról */
	$message = "Regisztráltak a wjsz-en " . $name . " néven, " . $username . " felhasználónévvel, " . $email . " email címmel.";
	mail("nyiti28@gmail.com","wjsz reg",$message); endif ?> 

	<p><span id="error"><?=$error?></span></p>
	
</form>
</div>