<?php 

/** VÁLTOZÓK DEKLARÁLÁSA **/

$mod = 1;

if (isset($_GET['members_id'])) { $members_id = $_GET['members_id']; }
if (isset($_GET['mod'])) { $mod = $_GET['mod']; }

/** ADATBÁZISBÓL TÖRLÉS **/

if ($mod == 3) 
{
	if($members_id != 0)
	{
		$sql = sprintf("DELETE FROM members WHERE members_id = %d",$members_id); 
		$mysqli->query($sql); 
	}
}
?>

<style> .ib table{ margin:0 auto } </style>

<div class=center><div class=ib>	
<h1>Edit members</h1>

<p><a href="Admin/Members/Edit/"><u>New member</u></a></p>


<table id="tag">
	<tr>
		<th width="220"><a href="./Admin/Members/?mod=1"><u>Order by Name</u></a></th> <th width="100"><a href="./Admin/Members/?mod=2"><u>Order by Status</u></a></th> <!--<th width="100">Sorrend</th>--> <th width="70">Delete</th>
	</tr>
	
	<?php
		if($mod==1) $insert = "name, status_order"; else $insert = "status_order, name";
		$sql = sprintf("SELECT * FROM members ORDER BY %s",$insert); 
		$data = array('members_id' => '','name' => '','status_order' => '');
		$result = $mysqli->query($sql);
		$it = 1;
		while ($row = $result->fetch_assoc()) { 
			$data = $row;
			$members_id = $data['members_id'];
			$sql = sprintf("SELECT status_name FROM members_status WHERE status_order = %s",$data['status_order']); 
			$status_result = $mysqli->query($sql);
			$status_data = $status_result->fetch_assoc();
	?>
	
	<tr>
		<td><?php echo $data['name'];  ?></td> 
		<td><?php echo $status_data['status_name'];  ?></td> 
		<!--<td><?php echo $data['status_order'];  ?></td> -->
		<td><u><a href="<?php echo "./Admin/Members/?mod=3&members_id=$members_id"; ?>">Delete</a></u></td>
	</tr>
	
	<?php $it++; } ?>
</table>


</div></div>