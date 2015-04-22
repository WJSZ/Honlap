<div id="content">

		<h1><?php if($lang=='hu'){echo'A Szakkollégium tagjai';} if($lang=='eng'){echo'Members of the College';}?></h1>
<p align="center"><u><a href="Tagok/?#tagok"><?php if($lang=='hu'){echo'Ugrás a Tagokra';} if($lang=='eng'){echo'Jump to Members';}?></a></u></p>

<!-- ELNÖKSÉG -->
		<h2><?php if($lang=='hu'){echo'Elnökségi tagok:';} if($lang=='eng'){echo'Presidency:';}?></h2>

<?php
	$sql = sprintf("SELECT nev, poszt, email, elnokid FROM elnok ORDER BY elnokid"); 
	$result = $mysqli->query($sql);
	$it = 1;
	while ($data = $result->fetch_assoc()) { 

	$ekezetek = array('á', 'é', 'í', 'ó', 'ö', 'ő', 'ú', 'ü', 'ű', 'Á', 'É', 'Í', 'Ó', 'Ö', 'Ő', 'Ú', 'Ü', 'Ű', ' ');
	$ekezetmentesek = array('a', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'u', 'A', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'U', '_');
	$name = str_replace($ekezetek, $ekezetmentesek, $data['nev']);
?>
	
	<div class="tag"><img src="pic/profil/<?php echo $name; ?>.png"/>
		<h3 class="elnok-tag-h3"><?php echo $data['nev']; ?></h3> 
		<p class="tag-p"><?php echo $data['poszt']; ?> <br>
		<?php echo $data['email']; ?></p>
	</div>
	
<?php $it++; } ?>

<!-- TISZTELETBELI TAG -->
		<h2><a id="tagok" style="text-decoration:none"><?php if($lang=='hu'){echo'Tiszteletbeli Tag:';} if($lang=='eng'){echo'Honorary Member:';}?></a></h2>
<h3><table width="300">
<tr><td width="100"><img src="pic/profil/Vanko_Peter.png"></td><td width="200">Vankó Péter</td></tr>
</table></h3>


<!-- TAGOK -->
		<h2 class="floatclear"><?php if($lang=='hu'){echo'Tagok:';} if($lang=='eng'){echo'Members:';}?></h2>

<?php
	$sql = sprintf("SELECT nev FROM tagok ORDER BY nev"); 
	$result = $mysqli->query($sql);
	$it = 1;
	while ($data = $result->fetch_assoc()) { 

	$ekezetek = array('á', 'é', 'í', 'ó', 'ö', 'ő', 'ú', 'ü', 'ű', 'Á', 'É', 'Í', 'Ó', 'Ö', 'Ő', 'Ú', 'Ü', 'Ű', ' ');
	$ekezetmentesek = array('a', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'u', 'A', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'U', '_');
	$name = str_replace($ekezetek, $ekezetmentesek, $data['nev']);
?>
	
	<div class="tag"><img src="pic/profil/<?php echo $name; ?>.png"/><h3 class="tag-h3"><?php echo $data['nev']; ?></h3></div>
	
<?php $it++; } ?>


	<h2 class="floatclear"><?php if($lang=='hu'){echo'Öregdiákok:';} if($lang=='eng'){echo'Former Members:';}?></h2>

<?php
	$sql = sprintf("SELECT nev FROM volt ORDER BY nev"); 
	$result = $mysqli->query($sql);
	$it = 1;
	while ($data = $result->fetch_assoc()) { 
?>

<h3><?php echo $data['nev']; ?></h3>

<?php $it++; } ?>


<p align="center"><u><a href="Tagok/?#headbox"><?php if($lang=='hu'){echo'ugrás az oldal elejére';} if($lang=='eng'){echo'Jump to the top';}?></a></u></p>

</div>
