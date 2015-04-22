<?php 
$hir = isset($_GET['hir']) ? $_GET['hir'] : '';
?>
	
<div id="content">
	<?php if($hir == '') {	?>
	<div class="slider-wrapper theme-default">
		<div class="ribbon"></div>
		<div id="slider" class="nivoSlider">
			<img src="pic/slide/01.jpg" alt="" />
			<img src="pic/slide/02.jpg" alt="" />
			<img src="pic/slide/03.jpg" alt="" />
			<img src="pic/slide/04.jpg" alt="" />
			<img src="pic/slide/05.jpg" alt="" />
			<img src="pic/slide/06.jpg" alt="" />
			<img src="pic/slide/07.jpg" alt="" />
			<img src="pic/slide/08.jpg" alt="" />
		</div>
	</div>
	<?php } ?>
	
	<h1 id="hir" style="margin-top:0"><?php if($lang=='hu'){echo'Hírek';} if($lang=='eng'){echo'News';}?></h1>

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

<script>
$(function() {
	$('#slider').nivoSlider({
		effect: 'fade',
		animSpeed: 300,
		directionNav: true,
		controlNav: true,
		pauseTime: 3000
	});

});
</script>

</div>