<!DOCTYPE html>
<html lang="<?php echo"$lang";?>">
<head>
	<?php if($_SERVER['SERVER_NAME'] == 'localhost') 
	           echo '<base href="http://localhost/beta/"> ';
		  else echo '<base href="https://wjsz.bme.hu'.$home.'"> '; ?>
	<meta charset="UTF-8">
	<meta name="author" content="Nyitrai Gábor">
	<meta name="description" content="WJSz - A Budapesti Műszaki Egyetem Wigner Jenő Szakkollégium honlapja">
	<meta name="viewport" content="width=device-width">
	<title><?php if($lang=='hu'){echo'Wigner Jenő Szakkollégium';} 
				 if($lang=='eng'){echo'Eugene Wigner College of Advanced Studies';}?></title>
	<link rel="icon" href="pic/favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="style/stylesheet.css" media="(min-width: 850px)" />
	<link rel="stylesheet" type="text/css" href="style/mobile.css" media="(max-width: 849px)" />
	
	<!-- jQuery -->
	<script src="style/jquery-2.1.1.min.js" type="text/javascript"></script>

	<!-- CodeMirror beállítások -->
	<?php if($PageFile == 'AdminWeboldalUj') require_once('style/CodeMirror-setup.php'); ?>

	<!-- Jssor slider beállítások -->
	<script type="text/javascript" src="style/JssorSlider/js/jssor.slider.mini.js"></script>

	<!-- NivoSlider beállítások -->
	<link rel="stylesheet" type="text/css" href="style/NivoSlider/nivo-slider.css"/>
	<link rel="stylesheet" type="text/css" href="style/NivoSlider/themes/default/default.css"/>
	<script type="text/javascript" src="style/NivoSlider/jquery.nivo.slider.pack.js"></script>

	<!-- egyéb script-ek -->
	<script type="text/javascript">

// subpage megjelenítés/elrejtés
function displayPage(id){
	for (var i = 1; i < 12; i++){
		var disp = 'none'; if(i == id) { disp = 'inline'; }
		document.getElementById('Page'+i).style.display = disp;
		document.getElementById('Page'+i).focus();
	}
}

// Google Analytics
<?php if($_SERVER['SERVER_NAME'] != 'localhost') : ?>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-49605382-1', 'bme.hu');
ga('send', 'pageview');
<?php endif; ?>

	</script>
</head>

<body>

<div class="wrapper">
<div id="headbox">

	<div id="cim"> <!-- Cím és logó -->
		<a href="">
			<img src="pic/wjszlogo.png" alt="WJSz logo" />
			<h1><?php if($lang=='hu'){echo'Wigner Jenő Szakkollégium';} 
			          if($lang=='eng'){echo'Eugene Wigner College of Advanced Studies';}?></h1>
		</a>
	</div>
	
	<!--<div id="search">
		<form name="google search" method="get" action="http://www.google.com/search">
			<input type="text" name="q" size="21" maxlength="120">
			<input type="submit" value="search">
		</form>
	</div>-->

	<div id="jump"> <!-- Átirányító ikonok -->
		<a href="https://www.facebook.com/wjsz.bme" target="blank"><img src="pic/f2.png" alt="facebook" /></a>
		<a href="<?php echo $url ?>?lang=hu"><img src="pic/hun.png" alt="magyar zaszlo" /></a>
		<a href="<?php echo $url ?>?lang=eng"><img src="pic/eng.png" alt="english flag" /></a>
		<!--<a href="rolunk/eng.php"><img src="pic/eng.png" alt="english flag" /></a> oldallátogatás indexeléshez-->
	</div>

	<?php if (isset($_SESSION['user_id'])) : ?>
		<div id="headtextbox">
			<p>Helló <?php echo $_SESSION['username'] ?>!</p> 
			<p><a href="Kilep/"><u>Kilépés</u></a></p> 
		</div>
	<?php endif ?>
	
</div>

<?php
//-- menü beállítás --//
if( $urls[0] == 'Tag' || $urls[0] == 'Admin') 
	require('inc/menu-profil.php');
else 
	require('inc/menu-main.php');
?>