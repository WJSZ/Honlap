<?php

$sql = sprintf("SELECT * 
                FROM esemeny e
                INNER JOIN esemeny_cimke ec
				ON e.esemeny_id = ec.esemeny_id
				WHERE ec.cimke = 'galéria'
				ORDER BY ido DESC");
if($result = $mysqli->query($sql)) null;
else echo "Adatbázis lekérdezési hiba: $mysqli->error";

$HTML = "<div id=\"gall\">\n";
while($row = $result->fetch_object() ){
	$folder = replace_accented_chars($row->nev);
	$HTML .= "
<div id=\"gallery\">
	<a href=\"Galeria/Kepek/?galeria_id=$row->esemeny_id\">
		<img src=\"pic/galeria/$folder/folder_thumb.jpg\">
	</a>
	<p>$row->nev</p>
</div>\n";
	if(isset($_GET['galeria_id']))
		if($row->esemeny_id == $_GET['galeria_id'])
			$NEV = $row->nev;
}
$HTML .= "</div>\n";

if(isset($_GET['galeria_id'])){
	$folder = replace_accented_chars($NEV);
	$original = "pic/galeria/$folder/original/";
	$thumbnail = "pic/galeria/$folder/thumbnail/";
	
	$kepek='';
	$counter=1;
	$skip=array(1,2);
	
	foreach(scandir($original) as $file){
		if(in_array($counter,$skip)){
			$counter++;
			continue;
		}
		$thumbfile = implode(explode('.',$file,-1)) . '_thumb.jpg';
		$kepek .= "<div><img u=\"image\" src=\"$original$file\">\n";
		$kepek .= "<img u=\"thumb\" src=\"$thumbnail$thumbfile\"></div>\n";
	}
	require_once('GaleriaKepek_jssor.php');
}
?>

<h1>Képek</h1>

<?=$HTML?>