<?php

$voteid=0;
$close=0;
$error='';
if (isset($_GET['voteid'])) { $voteid = $_GET['voteid']; }
if (isset($_GET['close'])) { $close = $_GET['close']; }

if($close)
{
	$sql = sprintf("UPDATE votes SET is_active = 0 WHERE vote_id = %d", $voteid); 
	$result = $mysqli->query($sql);
	if(!$result) $error="Adatbázislekérdezési hiba: $mysqli->error"; //Adatbázislekérdezés ellenőrzés
	$sql = sprintf("SELECT * FROM votes WHERE vote_id = %d", $voteid); 
	$result = $mysqli->query($sql);
	if(!$result) $error="Adatbázislekérdezési hiba: $mysqli->error"; //Adatbázislekérdezés ellenőrzés
	$votes = $result->fetch_assoc();
	$sql = sprintf("UPDATE users SET voted_%d = 0 ", trim($votes['vote_flag']) ); 
	$result = $mysqli->query($sql);
	if(!$result) $error="Adatbázislekérdezési hiba: $mysqli->error"; //Adatbázislekérdezés ellenőrzés
}

/* Check the number of active votes */
$sql = "SELECT count(vote_id) as count FROM `votes` WHERE is_active = 1";
$result = $mysqli->query($sql);
if(!$result) $error="Adatbázislekérdezési hiba: $mysqli->error"; //Adatbázislekérdezés ellenőrzés
$data = $result->fetch_assoc();
if($data['count'] < 10) $link = "<p><a href=\"Admin/Votes/Edit/\"><u>New vote</u></a></p>";
else $link = "<p>Cannot create new vote, because the maximum number of active votes is 10.</p>";
?>
<div id="content">
		
<h1>Edit votes</h1>

<p><span id="error"><?php echo "$error"; ?></span></p> <!--Hibaüzenet kiiratás-->

<?=$link?>

<table style="width:800px;margin:0px 0px 0px -100px;">
	<?php
		$sql = sprintf("SELECT * FROM votes ORDER BY create_date DESC"); 
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) { 
			$data = $row;
			$voteid = $data['vote_id'];
	?>

	<tr>
		<td><?php if($data['is_active']) echo "<u><a href=\"./Admin/Votes/Edit/?voteid=$voteid\">Edit</a></u></td><td>
		<u><a href=\"./Admin/Votes/?voteid=$voteid&close=1\">Close</a></u>"; else echo "</td><td>Closed" ?></td>
		<td><?php echo $data['create_date']." (".$data['creator'].")"; ?></td> 
		<td style="width:540px"><h3><?php echo $data['vote_title_hu']; ?></h3></td> 
	</tr>
	
	<?php $it++; } ?>
	
</table>
</div>
