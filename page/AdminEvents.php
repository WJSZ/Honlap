
<div id="content">
		
<h1>Edit Events</h1>

<p><a href="Admin/Events/Edit/"><u>New event</u></a></p>

<table>
	<?php
		$sql = sprintf("SELECT hirid, datum, cim FROM hir ORDER BY datum DESC"); 
		$data = array('hirid' => '','cim' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) { 
			$data = $row;
			$hirid = $data['hirid'];
	?>

	<tr>
		<td><u><a href="<?php echo "./Admin/Events/Edit/?hirid=$hirid"; ?>">Edit</a></u></td>
		<td><?php echo $data['datum']; ?></td> 
		<td><h3><?php echo $data['cim']; ?></h3></td> 
	</tr>
	
	<?php $it++; } ?>
	
</table>
</div>