
<style> .ib table{ margin:0 auto } </style>

<div class=center><div class=ib>	
<h1>Tagok</h1>

<p>Elnökségi tagok:</p>

<table id="tag">
	<tr>
		<th width="220">Név</th> <th width="200">Poszt</th> <th width="150">E-mail cím</th>
	</tr>
	
	<?php
		$sql = sprintf("SELECT elnokid, nev, poszt, email FROM elnok"); 
		$data = array('elnokid' => '','nev' => '','poszt' => '','email' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) { 
			$data = $row;
			$elnokid = $data['elnokid'];
	?>
	
	<tr>
		<td><?php echo $data['nev']; $name=$data['nev'] ?></td> 
		<td><?php echo $data['poszt']; ?></td> 
		<td><?php echo $data['email']; $email=$data['email'] ?></td> 
	</tr>
	
	<?php $it++; } ?>
	
</table>

<p>Tagok:</p>

<table id="tag">
	<tr>
		<th width="220">Név</th> <th width="100">Státusz</th>
	</tr>
	
	<?php
		$sql = sprintf("SELECT nev, statusz FROM tagok ORDER BY nev"); 
		$result = $mysqli->query($sql);
		$it = 1;
		while ($data = $result->fetch_assoc()) { 
	?>
	
	<tr>
		<td><?php echo $data['nev'];  $name=$data['nev']; ?></td> 
		<td><?php echo $data['statusz']; if ($data['statusz'] == 'aktív') { $poszt=1; } else $poszt=2; ?></td> 
	</tr>
	
	<?php $it++; } ?>
	
</table>

<p>Volt tagok:</p>

<table id="tag">
	<tr>
		<th width="220">Név</th>
	</tr>
	
	<?php
		$sql = sprintf("SELECT voltid, nev FROM volt ORDER BY nev"); 
		$data = array('voltid' => '','nev' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) {
			$data = $row;
			$voltid = $data['voltid'];
	?>
	
	<tr>
		<td><?php echo $data['nev'];  $name=$data['nev']; ?></td> 
	</tr>
	
	<?php $it++; } ?>
	
</table>

<p>Tiszteletbeli tagok:</p>

<table id="tag">
	<tr>
		<th width="220">Név</th>
	</tr>
	
	<?php
		$sql = sprintf("SELECT honorid, nev FROM honor ORDER BY nev"); 
		$data = array('honorid' => '','nev' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) { 
			$data = $row;
			$honorid = $data['honorid'];
	?>
	
	<tr>
		<td><?php echo $data['nev'];  $name=$data['nev']; ?></td> 
	</tr>
	
	<?php $it++; } ?>
	
</table>
</div></div>