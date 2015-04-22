<?php 

$error='';
$cim='';
$absztrakt='';
$szoveg='';
$hirid='';

if(isset($_GET['hirid']))
{
	$hirid = $_GET['hirid'];
	$sql = sprintf('SELECT cim, absztrakt, szoveg FROM hir WHERE hirid = %d',$hirid);
	$result = $mysqli->query($sql);
	$data = $result->fetch_assoc();
	$cim = $data['cim'];
	$absztrakt = $data['absztrakt'];
	$szoveg = $data['szoveg'];
}

if($_POST) // Szöveg frissítése
{
	if(isset($_POST['cim'])){ $cim = $mysqli->real_escape_string($_POST['cim']); }
	if(isset($_POST['absztrakt'])){ $absztrakt = $mysqli->real_escape_string($_POST['absztrakt']); }
	if(isset($_POST['szoveg'])){ $szoveg = $mysqli->real_escape_string($_POST['szoveg']); }
	if($_POST['hirid'] != '')
	{	
		$sql = sprintf("UPDATE hir SET cim='%s', absztrakt ='%s', szoveg ='%s', szerzo='%s' WHERE hirid ='%d'", $cim, $absztrakt, $szoveg, $_SESSION['username'], $_POST['hirid']);
		$mysqli->query($sql);
	}
	if($_POST['hirid'] == '')
	{
		$sql = sprintf("INSERT INTO hir SET cim='%s', absztrakt ='%s', szoveg ='%s', szerzo='%s'", $cim, $absztrakt, $szoveg, $_SESSION['username']);
		$mysqli->query($sql);
	}	
	header('Location: '.$home.'Admin/Hirek/'); 
}
?>

<div id="content">
<h1>Hírek szerkesztése</h1>

<p><span id="error"><?php echo "$error"; ?></span></p> <!--Hibaüzenet kiiratás-->

<form id="profil" class="bigform center" action="" method="post" >
	<input type="hidden" name="hirid" value="<?php echo $hirid ?>"/>
	<p>
		<label>Cím: </label>
		<input id="hircim" name="cim" size="700" value="<?php echo $cim ?>" autocomplete="off" autofocus />
	</p>
	<p>
		<label>Összefoglaló: (max 1000 karakter)</label>
		<textarea rows="8" cols="70" maxlength="1000" name="absztrakt" /><?php echo $absztrakt ?></textarea>
	</p>
	<p>
		<label>Tartalom: </label>
		<textarea rows="20" cols="70" maxlength="10000" name="szoveg" /><?php echo $szoveg ?></textarea>
	</p>
	<p><button id="button">Mentés</button></p>
</form>
</div>