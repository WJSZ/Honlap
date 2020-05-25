<?php 

/** Adatbázis módosítás **/

$proc = '';
$id = 0;
if (isset($_GET['proc'])) { $proc = $_GET['proc']; }
if (isset($_GET['id'])) { $id = $_GET['id']; }

if ($proc == 'del') 
{
	if (!empty($id)) 
	{
		/* értesítés emailben */
		$sql = sprintf("SELECT email FROM users WHERE id = %s", $id); 
		$result = $mysqli->query($sql);	$data = $result->fetch_assoc();	$link = $data['email'];
		$message = "Szia! \n\n Töröltünk a wjsz.bme.hu oldalról \n\n Üdv: admin ";
		mail($link,"wjsz regisztracio torolve",$message);
				
		$sql = sprintf("DELETE FROM users WHERE id = %d",$id); 
		$mysqli->query($sql); 		
	}
}
if ($proc == 'confirm') 
{
	if (!empty($id)) 
	{
		$sql = sprintf("UPDATE users SET confirmed = 1 WHERE id = %d", $id); 
		$mysqli->query($sql); 
		
		/* értesítés emailben */
		$sql = sprintf("SELECT email FROM users WHERE id = %s", $id); 
		$result = $mysqli->query($sql);	$data = $result->fetch_assoc();	$link = $data['email'];
		$message = "Szia! \n\n A regszitrációd jóvá lett hagyva, mostmár beléphetsz! \n\n Üdv: admin ";
		mail($link,"wjsz regisztracio jovahagyva",$message);
	}
}
if ($proc == 'noadmin') 
{
	if (!empty($id)) 
	{
		$sql = sprintf("UPDATE users SET admin = 0 WHERE id = %d", $id); 
		$mysqli->query($sql); 
	}
}
if ($proc == 'admin') 
{
	if (!empty($id)) 
	{
		$sql = sprintf("UPDATE users SET admin = 1 WHERE id = %d", $id); 
		$mysqli->query($sql); 
	}
}
if ($proc == 'tovote') 
{
	if (!empty($id)) 
	{
		$sql = sprintf("UPDATE users SET can_vote = 1 WHERE id = %d", $id); 
		$mysqli->query($sql); 
	}
}
if ($proc == 'novote') 
{
	if (!empty($id)) 
	{
		$sql = sprintf("UPDATE users SET can_vote = 0 WHERE id = %d", $id); 
		$mysqli->query($sql); 
	}
}
?>	
<h1>Edit users</h1>

<p class=center>Please notify them by email whose registration was approved. </p>

<div style="width:800px; margin:0 auto;">
<form action="" method="post">
	<input type="hidden" name="proc"/>
	<input type="hidden" name="id" />
	<table id="admin">

		<tr>
			<th>Name</th> <th>Username</th> <th>E-mail</th> <th>Reg. date</th> <th>Approve</th> <th>Can Vote</th> <th>Admin</th> <th>Delete</th>
		</tr>
		
		<?php
			$sql = sprintf("SELECT id, name, username, email, regdate, confirmed, admin, can_vote FROM users ORDER BY regdate DESC"); 
			$result = $mysqli->query($sql);
			$it = 1;
			while ($data = $result->fetch_assoc()) { 
				$id = $data['id'];
		?>
		
		<tr>
			<td><?php echo $data['name'] ?></td> 
			<td><?php echo $data['username'] ?></td> 
			<td><?php echo $data['email'] ?></td> 
			<td><?php echo substr($data['regdate'],0,10); ?></td> 
<!---------------------------->
			<?php if( $data['confirmed'] == 1) {  ?>
			<td>Approved</td>

			<?php } else { ?>
			<td><a href="<?php echo "./Admin/Users/?proc=confirm&id=$id" ?>"><u>to approve</u></a></td><?php } ?>
<!---------------------------->
			<?php if( $data['can_vote'] == 1) { ?>	
			<td>YES, <u><a href="<?php echo "./Admin/Users/?proc=novote&id=$id"; ?>">cancel.</a></u></td>

			<?php } else { ?>
			<td>no, <u><a href="<?php echo "./Admin/Users/?proc=tovote&id=$id"; ?>">rather YES.</a></u></td>

			<?php } ?>
<!---------------------------->
			<?php if( $data['admin'] == 1) { ?>	
			<td>Admin. <u><a href="<?php echo "./Admin/Users/?proc=noadmin&id=$id"; ?>">don't be admin</a></u></td>

			<?php } else { ?>
			<td><u><a href="<?php echo "./Admin/Users/?proc=admin&id=$id"; ?>">to be admin</a></u></td>

			<?php } ?>
<!---------------------------->
			<td><u><a href="<?php echo "./Admin/Users/?proc=del&id=$id"; ?>">Delete</a></u></td>
			
		</tr>
		
		<?php $it++; } ?>
		
	</table>
</form>
</div>