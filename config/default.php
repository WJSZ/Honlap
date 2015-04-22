<?php
//-- alapbeállítások --//
	header("Content-type: text/html;charset=utf-8"); // karakterkódolás
	require('config/database.php');                  // adatbázis kapcsolódás
	require('inc/functions.php');                    // függvények betöltése
	session_start();
	ob_start();

//-- nyelv beállítás --//
	if(!isset($_SESSION['lang'])) { $_SESSION['lang']='hu'; }
	if(isset($_GET['lang'])) { $_SESSION['lang'] = $_GET['lang']; }
	$lang = $_SESSION['lang'];

//-- URL kiolvasás --//
	$request_uri = $_SERVER['REQUEST_URI'];
	$qpos = strpos( $request_uri , '?' );           // kérdőjel pozíció meghatározás
	$pos = $qpos ? $qpos : strlen( $request_uri );  // url hossz meghatározás
	$url = substr( $request_uri , 1 , $pos - 1 );   // query levágása
	$beta='';
	if(substr($url,0,4)=='beta'){
		$beta = '/beta';                            // ha béta volt akkor a válozót feltöltjük
		$url = substr($url,5,strlen($url));         // beta/ levágása
	}
	$urls = explode('/', $url );                    // URL szétbontás tömbbe

//-- alapértelmezett értékek --//
	// WJSZ kezdőoldal
	$urls[1] = isset($urls[1]) ? $urls[1] : '';
	if(!$url){
		$sql = sprintf("SELECT href FROM menu WHERE listpos = 0 AND sublistpos = 0");
		$url = implode($mysqli->query($sql)->fetch_assoc());
	}
	// Hitelesített kezdőoldalak
	$user_home = "$beta/Tag/Naptar/";
	$admin_home = "$beta/Admin/Felhasznalok/";
	$home = "$beta/";

//-- biztonság, átirányítás
	if(($urls[0] == 'Admin' || $urls[0] == 'Tag') && !isset($_SESSION['admin'])){
		header("Location: $home");exit;
	}

//-- HTML string-ek --//
$errorDIV='
<div id="log" style="background-color:red;
                     color:white;
					 font-weight:bold;
					 width:350px;
					 margin:auto;
					 margin-top:20px;
					 text-align:center;
					 padding:10px;">';
?>