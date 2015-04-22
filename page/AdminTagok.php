<?php 

/** VÁLTOZÓK DEKLARÁLÁSA **/

$mod = 0;
$elnokid = 0;
$tagid = 0;
$voltid = 0;
$honorid = 0;
if (isset($_GET['elnokid'])) { $elnokid = $_GET['elnokid']; }
if (isset($_GET['tagid'])) { $tagid = $_GET['tagid']; }
if (isset($_GET['voltid'])) { $voltid = $_GET['voltid']; }
if (isset($_GET['honorid'])) { $honorid = $_GET['honorid']; }
if (isset($_GET['mod'])) { $mod = $_GET['mod']; }

/** ADATBÁZISBÓL TÖRLÉS **/

if ($mod == 3) 
{
	if($elnokid != 0)
	{
		$sql = sprintf("DELETE FROM elnok WHERE elnokid = %d",$elnokid); 
		$mysqli->query($sql); 
	}
	if($tagid != 0)
	{
		$sql = sprintf("DELETE FROM tagok WHERE tagid = %d",$tagid); 
		$mysqli->query($sql); 
	}
	if($voltid != 0)
	{
		$sql = sprintf("DELETE FROM volt WHERE voltid = %d",$voltid); 
		$mysqli->query($sql); 
	}
	if($honorid != 0)
	{
		$sql = sprintf("DELETE FROM honor WHERE honorid = %d",$honorid); 
		$mysqli->query($sql); 
	}
}
?>

<style> .ib table{ margin:0 auto } </style>

<div class=center><div class=ib>	
<h1>Tagok szerkesztése</h1>

<p><a href="Admin/Tagok/Uj/"><u>Új tag felvitele</u></a></p>

<p>Elnökségi tagok:</p>

<table id="tag">
	<tr>
		<th width="220">Név</th> <th width="200">Poszt</th> <th width="150">E-mail cím</th> <th width="70">Törlés</th>
	</tr>
	
	<?php
		$sql = sprintf("SELECT elnokid, nev, poszt, email FROM elnok"); 
		$data = array('elnokid' => '','nev' => '','poszt' => '','email' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) { 
			$data = $row;
			$elnokid = $data['elnokid'];
	?>
	
	<tr>
		<td><?php echo $data['nev']; $name=$data['nev'] ?></td> 
		<td><?php echo $data['poszt']; ?></td> 
		<td><?php echo $data['email']; $email=$data['email'] ?></td> 
		<td><u><a href="<?php echo "./Admin/Tagok/?mod=3&elnokid=$elnokid"; ?>">Töröl</a></u></td>
	</tr>
	
	<?php $it++; } ?>
	
</table>


<p>Tagok:</p>

<table id="tag">
	<tr>
		<th width="220">Név</th> <th width="100">Státusz</th> <th width="70">Törlés</th>
	</tr>
	
	<?php
		$sql = sprintf("SELECT tagid, nev, statusz FROM tagok ORDER BY nev"); 
		$data = array('tagid' => '','nev' => '','statusz' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) { 
			$data = $row;
			$tagid = $data['tagid'];
	?>
	
	<tr>
		<td><?php echo $data['nev'];  $name=$data['nev']; ?></td> 
		<td><?php echo $data['statusz']; if ($data['statusz'] == 'aktív') { $poszt=1; } else $poszt=2; ?></td> 
		<td><u><a href="<?php echo "./Admin/Tagok/?mod=3&tagid=$tagid"; ?>">Töröl</a></u></td>
	</tr>
	
	<?php $it++; } ?>
	
</table>


<p>Volt tagok:</p>

<table id="tag">
	<tr>
		<th width="220">Név</th> <th width="70">Törlés</th>
	</tr>
	
	<?php
		$sql = sprintf("SELECT voltid, nev FROM volt ORDER BY nev"); 
		$data = array('voltid' => '','nev' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) {
			$data = $row;
			$voltid = $data['voltid'];
	?>
	
	<tr>
		<td><?php echo $data['nev'];  $name=$data['nev']; ?></td> 
		<td><u><a href="<?php echo "./Admin/Tagok/?mod=3&voltid=$voltid"; ?>">Töröl</a></u></td>
	</tr>
	
	<?php $it++; } ?>
	
</table>


<p>Tiszteletbeli tagok:</p>

<table id="tag">
	<tr>
		<th width="220">Név</th> <th width="70">Törlés</th>
	</tr>
	
	<?php
		$sql = sprintf("SELECT honorid, nev FROM honor ORDER BY nev"); 
		$data = array('honorid' => '','nev' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) { 
			$data = $row;
			$honorid = $data['honorid'];
	?>
	
	<tr>
		<td><?php echo $data['nev'];  $name=$data['nev']; ?></td> 
		<td><u><a href="<?php echo "./Admin/Tagok/?mod=3&honorid=$honorid"; ?>">Töröl</a></u></td>
	</tr>
	
	<?php $it++; } ?>
	
</table>
</div></div>