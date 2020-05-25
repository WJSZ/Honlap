<?php 

/** VÁLTOZÓK DEKLARÁLÁSA **/

$status=1; $elnokid=0; $tagid=0; $voltid=0; $honorid=0; $elnokposzt = 0;

if (isset($_GET['mod'])) { $mod = $_GET['mod']; }
if (isset($_GET['status'])) { $status = $_GET['status']; }
if (isset($_GET['name'])) { $name = $_GET['name']; }
if (isset($_GET['email'])) { $email = $_GET['email']; }

$status_names = array('0' => '');
$sql = sprintf("SELECT * FROM members_status"); 
$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) { 
	$status_names[$row['status_order']] = $row['status_name'];
}

$error = ''; 

if($_POST)
{

if(isset($_POST['name'])) { $name = $_POST['name']; }
if (isset($_POST['status_order'])) { $status_order = $_POST['status_order']; }
		
/** ELLENŐRZÉSEK **/

if($name == '' ) { $error .= 'HIBA! Hiányzik a név!<br>';}
if($status_order == 0 ) { $error .= 'HIBA! Hiányzik a státusz!<br>';}

/** ADATBÁZIS ÍRÁS **/

if($error == '') 
{
	$sql = sprintf("INSERT INTO members SET name = '%s', status_order = '%s'", $name, $status_order);
	$mysqli->query($sql);
	$done=1; //Ha sikerült az adatbázis írás, akkor a változónak értéket ad
}
}
?>

<div id="content" class=center>

<h1>New member</h1>

<?php if(isset($done)) { ?> <span align="center"><p>The operation was successful. <u><a href="Admin/Tagok/">Back to the members</a></u> </span> <?php } ?>

<p><span id="error"><?php echo "$error"; ?></span></p> <!--Hibaüzenet kiiratás-->

<form id="profil" action="" method="post" >

	<p>
		<label>Status: </label>  
		<select name="status_order">
				<?php foreach($status_names as $status_order => $status_name) 
				echo "<option value=\"".$status_order."\">".$status_name."</option>";?>
		</select>
	</p>

	<p>
		<label>Name: </label>
		<input name="name" size="40" value="<?php echo $name ?>" autocomplete="off" autofocus/>
	</p>

	<p><button id="button">Mentés</button></p>
	
</form>
</div>