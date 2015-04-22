<?php

$error='';

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

if($_SESSION['username'] != $username ) 
{
	$sql = sprintf("SELECT * FROM users WHERE username = '%s' ", $username); //Vizsgálat: van-e ilyen felh.név
	$mysqli->query($sql);
	if($mysqli->affected_rows > 0){ $error .= 'HIBA! Már létezik ilyen felhasználónév!<br>';}
}

if($_SESSION['email'] != $email ) 
{
	$sql = sprintf("SELECT * FROM users WHERE email = '%s' ", $email); //Vizsgálat: van-e ilyen e-mail
	$mysqli->query($sql);
	if($mysqli->affected_rows > 0){ $error .= 'HIBA! Már regisztráltak ezzel az e-mail címmel!<br>';}
}

if(valid_email($email) == false) { $error .= 'HIBA! Érvénytelen e-mail cím!<br>';}

if($pass != '' ) //Jelszó ellenőrzések
 { 
	if($pass2 == '' ) { $error .= 'HIBA! Hiányzik a jelszó ismétlés!<br>';}
	if (strlen($pass) < 7){ $error .= 'HIBA! A jelszó túl rövid!<br>';}
	if ($pass!=$pass2){ $error .= 'HIBA! Nem egyezik a két jelszó!<br>';} 
	
	if($error == '') //Adatbázis jelszó frissítése
	{
		$sql = sprintf("UPDATE users SET pass = '%s' WHERE id = %d", sha1($pass), $_SESSION['user_id']);
		$mysqli->query($sql);
		$done=1;
	}
 }

/** ADATBÁZIS FRISSÍTÉS **/

if($error == '') 
 {
	$sql = sprintf("UPDATE users SET name = '%s', username = '%s', email = '%s' WHERE id = %d", $name, $username, $email, $_SESSION['user_id']);
	$mysqli->query($sql);
	$_SESSION['username'] = $username;
	$_SESSION['email'] = $email;
	$done=1;
 }
 
}

/** Jelenlegi adatok betöltése **/

$sql = sprintf("SELECT name, username, email FROM users WHERE id = '%d' LIMIT 1", $_SESSION['user_id']); 
$data = array('name' => '','username' => '','email' => '');
$result = $mysqli->query($sql);
if ($row = $result->fetch_assoc()) { $data = $row; }
?>

<div id="content">
		
<h1>Profil szerkesztése</h1>

<form id="profil" class="bigform center" method="post" action="">

	<?php if (isset($done)) : ?><p>A változtatásokat a rendszer mentette!</p><?php endif ?> <!--Ha volt adatbázis írás, akkor a $done értéket kapott, ezért ez jelenik meg-->
	
	<p><span id="error"><?php echo "$error"; ?></span></p> <!--Hibaüzenet kiiratás-->
	
    <p>
		<label>Név: </label>
		<input name="name" value="<?php echo $data['name'] ?>" autocomplete="off" autofocus/></p>
	<p>
		<label>Felhasználónév: </label>
		<input name="username" value="<?php echo $data['username']; ?>" autocomplete="off"/></p>
	<p>
		<label>E-mail cím: </label>
		<input type="email" name="email" value="<?php echo $data['email']; ?>" ></p>
    <p>
		<label>Új jelszó: </label>
		<input type="password" name="pass" placeholder="Jelszó (min 7 karakter)" autocomplete="off"/></p>
	<p>
		<label>Új jelszó ismét: </label>
		<input type="password" name="pass2" placeholder="Jelszó ismét" autocomplete="off"/></p>
	 
    <p><button id="button">Mentés</button></p>
	
</form>
</div>