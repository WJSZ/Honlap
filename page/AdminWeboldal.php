<?php 

// KEZDŐOLDAL OPCIÓK BETÖLTÉSE
$locationOpts='<option value="0">...</option>';
$sql = sprintf("SELECT location FROM content");
$result = $mysqli->query($sql);
while($row = $result->fetch_assoc()){
	$locationOpts .= '<option>'.
	                $row['location'].
					'</option>';
}

// KEZDŐOLDAL FRISSÍTÉS
$error='';
if($_POST){
	if(!isset($_POST['newHomeLocation'])) $error = 'Nincs kiválasztva új URL!';
	if(!$error){
		$sql = sprintf("UPDATE menu SET href='%s' WHERE listpos = 0",$_POST['newHomeLocation']);
		if( $mysqli->query($sql) ) $error = 'Sikeresen frissült a kezdőoldal!';
		else $error = $mysqli->errno.'<br>'.$mysqli->error.'<br>SQL: '.$sql;
	}
}

// GOMB LISTA GENERÁLÁS
$HTMLa='';
$sql = sprintf("SELECT * FROM menu");
$result = $mysqli->query($sql);
while($row = $result->fetch_assoc()){
	if(!$row['listpos']){
		$href = $row['href'];
		continue;
	}
	$style='style="font-size:120%;padding:5px;display:block; ';
	if($row['sublistpos']) $style .= 'margin-left:30px; ';
	if($row['style'] == 'display:none;') $style .= 'color:red; ';
	$style.='"';
	$HTMLa .= '<a href="Admin/Weboldal/Uj/?listpos='.
				   $row['listpos'].
				   '&sublistpos='.
				   $row['sublistpos'].
				   '" '.$style.'>'.
			   $row[$lang.'_name'].
			   '</a>';
}

$showERROR = ''; if($error) $showERROR = $errorDIV.$error.'</div>';
?>

<?=$showERROR?>

<div id="content">
<h2>Kezdőoldal:</h2>
<form method="post" action="">
	<p>Jelenlegi URL:<input type="text" value="<?=$href?>" readonly>
	<span style="margin-left:40px;"></span>
	Új URL:<select name=newHomeLocation><?=$locationOpts?></select></p>
	<div class="center">
		<p><button style="padding:5px 15px 5px 15px;">Új kezdőoldal beállítása</button></p>
	</div>
</form>

<h2 style="margin-bottom:20px;">Gombok és tartalmak szerkesztése:</h2>
<p><a href="Admin/Weboldal/Uj/" style="color:white">+ Új felvitel</a></p>
<?=$HTMLa?>
<p>(piros rejtett)</p>
