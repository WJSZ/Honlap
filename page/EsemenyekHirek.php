<?php 
$hir = isset($_GET['hir']) ? htmlspecialchars($mysqli->real_escape_string($_GET['hir'])) : '';
?>
	
<div id="content">

	<h1 id="hir" ><?php if($lang=='hu'){echo'Események';} if($lang=='eng'){echo'Events';}?></h1>

	<?php
if($hir == '')
{
		$sql = sprintf("SELECT hirid, datum, cim, szerzo, absztrakt, szoveg FROM hir ORDER BY datum DESC"); 
		$data = array('hirid' => '','datum' => '','cim' => '','szerzo' => '','absztrakt' => '','szoveg' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) { 
			$data = $row;
	?>
	
<h2><?php echo $data['cim']; ?></h2> 

<h4><u>Bejegyzés: <?php echo $data['szerzo']; ?>, <?php echo $data['datum']; ?></u></h4> 
	
<p><?php $csere = array("\r\n", "\n", "\r"); echo str_replace($csere, '<br>', $data['absztrakt']); ?></p> 

<p><a href="<?=$contents['location']?>?hir=<?php echo $data['hirid'] ?>">Tovább...</a></p> 
	
<?php 
$it++;  } 
}
else
{
		$sql = sprintf("SELECT datum, cim, szerzo, absztrakt, szoveg FROM hir WHERE hirid='%d'", $hir); 
		$data = array('hirid' => '','datum' => '','cim' => '','szerzo' => '','absztrakt' => '','szoveg' => '');
		$result = $mysqli->query($sql);
		$data = $result->fetch_assoc();
?>
	
<h2><?php echo $data['cim']; ?></h2> 

<h4><u>Bejegyzés: <?php echo $data['szerzo']; ?>, <?php echo $data['datum']; ?></u></h4> 

<p><?php $csere = array("\r\n", "\n", "\r"); echo str_replace($csere, '<br>', $data['szoveg']); ?></p> 

<?php } ?>

</div>