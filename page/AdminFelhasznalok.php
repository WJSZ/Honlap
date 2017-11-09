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
?>	
<h1>Felhasználók kezelése</h1>

<p class=center>Kérlek ha valakit jóváhagysz, értesítsd őt e-mailben. Köszönöm!</p>

<div style="width:800px; margin:0 auto;">
<form action="" method="post">
	<input type="hidden" name="proc"/>
	<input type="hidden" name="id" />
	<table id="admin">

		<tr>
			<th>Név</th> <th>Felhasználónév</th> <th>E-mail cím</th> <th>Reg. idő</th> <th>Jóváhagyás</th> <th>Törlés</th> <th>Admin</th>
		</tr>
		
		<?php
			$sql = sprintf("SELECT id, name, username, email, regdate, confirmed, admin FROM users ORDER BY regdate DESC"); 
			$result = $mysqli->query($sql);
			$it = 1;
			while ($data = $result->fetch_assoc()) { 
				$id = $data['id'];
		?>
		
		<tr>
			<td><?php echo $data['name'] ?></td> 
			<td><?php echo $data['username'] ?></td> 
			<td><?php echo $data['email'] ?></td> 
			<td><?php echo $data['regdate'] ?></td> 
			
			<?php if( $data['confirmed'] == 1) {  ?>
			<td>Jóváhagyva</td>
			
			<?php } else { ?>
			<td><a href="<?php echo "./Admin/Felhasznalok/?proc=confirm&id=$id" ?>">Jóváhagy</a></td><?php } ?>
			
			<td><u><a href="<?php echo "./Admin/Felhasznalok/?proc=del&id=$id"; ?>">Töröl</a></u></td>
			
			<?php if( $data['admin'] == 1) { ?>	
			<td>Admin. <u><a href="<?php echo "./Admin/Felhasznalok/?proc=noadmin&id=$id"; ?>">Ne legyen admin</a></u></td>
			
			<?php } else { ?>
			<td><u><a href="<?php echo "./Admin/Felhasznalok/?proc=admin&id=$id"; ?>">Adminná emelés</a></u></td>

			<?php } ?>
		</tr>
		
		<?php $it++; } ?>
		
	</table>
</form>
</div>