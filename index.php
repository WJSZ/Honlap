<?php 
require('config/default.php');                  // alapbeállítások, nyelv, URL

$sql = sprintf("SELECT * 
                FROM content 
				WHERE location = '%s'",$url);
$contents = $mysqli->query($sql)->fetch_assoc();// tartalom kiolvasás adatbázisból$PageFile = str_replace('/','',$url);           // script fáljnév a location alapján

require('inc/head.php');                        // HTML begin

if (file_exists('page/'.$PageFile.'.php')) 
	require('page/'.$PageFile.'.php');          // script fájl betöltés

if($lang=='hu') echo $contents['hu_content']; 
if($lang=='eng')echo $contents['eng_content'];

require('inc/foot.php');                        // HTML end
?>