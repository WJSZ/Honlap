<?php 

/** VÁLTOZÓK DEKLARÁLÁSA **/

$poszt=1; $elnokid=0; $tagid=0; $voltid=0; $honorid=0; $elnokposzt = 0;

if (isset($_GET['mod'])) { $mod = $_GET['mod']; }
if (isset($_GET['poszt'])) { $poszt = $_GET['poszt']; }
if (isset($_GET['name'])) { $name = $_GET['name']; }
if (isset($_GET['email'])) { $email = $_GET['email']; }

$name = ''; $email = ''; $error = ''; 
$elnokposztok = array(
	'Elnök',
	'Alelnök',
	'Titkár',
	'Gazdasági mcsv.',
	'Kísérleti Kör mcsv.',
	'Oktatási és kapcsolatok mcsv.',
	'Programszervező mcsv.',
	'Számítástechnika mcsv.');
	
if($_POST)
{

if(isset($_POST['name'])) { $name = $_POST['name']; }
if(isset($_POST['email'])) { $email  = $_POST['email']; }
if (isset($_POST['poszt'])) { $poszt = $_POST['poszt']; }
if (isset($_POST['elnokposzt'])) { $elnokposzt = $_POST['elnokposzt']; }
		
/** ELLENŐRZÉSEK **/

if($name == '' ) { $error .= 'HIBA! Hiányzik a név!<br>';}
if($poszt == 3) 
{ 
	if($email == '' ) { $error .= 'HIBA! Hiányzik az email cím!<br>';} 

	$sql = sprintf("SELECT * FROM elnok WHERE email = '%s' ", $email); //Vizsgálat: van-e ilyen e-mail
	$mysqli->query($sql);
	if($mysqli->affected_rows > 0){ $error .= 'HIBA! Már van ilyen e-mail cím!<br>';}
	
	if(valid_email($email) == false) { $error .= 'HIBA! Érvénytelen e-mail cím!<br>';}
}

/** ADATBÁZIS ÍRÁS **/

if($error == '') 
{
	if($poszt == 1) 
	{ 	
		$statusz = 'aktív';
		$sql = sprintf("INSERT INTO tagok SET nev = '%s', statusz = '%s'", $name, $statusz);
		$mysqli->query($sql);
		$done=1; //Ha sikerült az adatbázis írás, akkor a változónak értéket ad
	}
	if($poszt == 2) 
	{ 	
		$statusz = 'passzív';
		$sql = sprintf("INSERT INTO tagok SET nev = '%s', statusz = '%s'", $name, $statusz);
		$mysqli->query($sql);
		$done=1;
	}
	if($poszt == 3) 
	{ 	
		$sql = sprintf("INSERT INTO elnok SET nev = '%s', poszt = '%s', email='%s'", $name, $elnokposztok[$elnokposzt], $email);
		$mysqli->query($sql);
		$done=1; 
	}
	if($poszt == 4) 
	{ 	
		$sql = sprintf("INSERT INTO volt SET nev = '%s'", $name);
		$mysqli->query($sql);
		$done=1; 
	}
	if($poszt == 5) 
	{ 	
		$sql = sprintf("INSERT INTO honor SET nev = '%s'", $name);
		$mysqli->query($sql);
		$done=1; 
	}
}
}
?>

<div id="content" class=center>

<h1>Új tag felvitele</h1>

<?php if(isset($done)) { ?> <span align="center"><p>A művelet sikeres volt. <u><a href="Admin/Tagok/">Vissza a tagokhoz</a></u> </span> <?php } ?>

<p><span id="error"><?php echo "$error"; ?></span></p> <!--Hibaüzenet kiiratás-->

<form id="profil" action="" method="post" >

    <p>
        <label>Szakkollégiumi státusz: </label>  
        <select name="poszt" onChange='window.location="Admin/Tagok/Uj/?poszt=" + this.value;'>
			<option value="1" <?php if($poszt == 1) { echo "selected"; } ?>>Aktív tag</option>
			<option value="2" <?php if($poszt == 2) { echo "selected"; } ?>>Passzív tag</option>
			<option value="3" <?php if($poszt == 3) { echo "selected"; } ?>>Elnökségi tag</option>
			<option value="4" <?php if($poszt == 4) { echo "selected"; } ?>>Volt tag</option>
			<option value="5" <?php if($poszt == 5) { echo "selected"; } ?>>Tiszteletbeli tag</option>
        </select>
    </p>

	<p>
		<label>Név: </label>
		<input name="name" value="<?php echo $name ?>" autocomplete="off" autofocus/>
	</p>
<?php if($poszt == 3) { ?>
	<p>
        <label>Elnökségi poszt:</label>  
        <select name="elnokposzt" >
            <option value="0"><?php echo $elnokposztok[0] ?></option>
            <option value="1"><?php echo $elnokposztok[1] ?></option>
			<option value="2"><?php echo $elnokposztok[2] ?></option>
			<option value="3"><?php echo $elnokposztok[3] ?></option>
			<option value="4"><?php echo $elnokposztok[4] ?></option>
			<option value="5"><?php echo $elnokposztok[5] ?></option>
			<option value="6"><?php echo $elnokposztok[6] ?></option>
			<option value="7"><?php echo $elnokposztok[7] ?></option>
        </select>
    </p>
	
	<p>
		<label>E-mail cím:</label>
		<input name="email" value="<?php echo $email; ?>" autocomplete="off">
	</p>
<?php } ?>
	<p><button id="button">Mentés</button></p>
	
</form>
</div>