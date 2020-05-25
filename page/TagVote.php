<?php

if(isset($_GET['voteid']) && $_POST)
{
	$sql = "SELECT * FROM users WHERE id=".$_SESSION["user_id"];
	$result = $mysqli->query($sql);
	if(!$result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
	$users = $result->fetch_assoc();
	if($users["voted_".trim($_POST['vote_flag'])] == 0)
	{
		$sql = "INSERT INTO vote_records SET vote_id=".$_GET['voteid'].", vote=".$_POST['vote'].", voter_name='".$_POST['username']."'";
		$result = $mysqli->query($sql);
		if(!$result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés

		$sql = "UPDATE users SET voted_".trim($_POST['vote_flag'])."=1 WHERE id=".$_SESSION["user_id"];
		$result = $mysqli->query($sql);
		if(!$result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
	}
}

?>

<style type="text/css">
p {
  margin-top:0px;
}
</style>

<div id="content">
		
<h1>Active votes</h1>

<?php
	$error = '';
	$sql = sprintf("SELECT * FROM users WHERE id = %s",$_SESSION["user_id"]); 
	$users_result = $mysqli->query($sql);
	if(!$users_result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
	$users = $users_result->fetch_assoc();
	if( $users['can_vote'] == 1)
	{
		$sql = sprintf("SELECT * FROM votes WHERE is_active=1 ORDER BY create_date DESC"); 
		$votes_result = $mysqli->query($sql);
		if(!$votes_result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
		$it = 1;
		while ($votes = $votes_result->fetch_assoc()) 
		{
			echo "<br><hr><h2 style=\"padding-top:0px;margin-bottom:0px;\">".$votes['vote_title_hu']."</h2>\n";
			echo "<h3>".$votes['vote_title_en']."</h3>\n";
			echo "<h4>Created: ".$votes['create_date']." (".$votes['creator'].")</h4>\n";
			$options='';
			$option_values = explode("\n",$votes['vote_options']);
			if($users['voted_'.trim($votes['vote_flag'])]==0)
			{
				$options.="<form action=\"/Tag/Vote?voteid=".$votes['vote_id']."\" method=\"post\">\n";
				if($votes['is_secret']) $username = "";
				else $username = $_SESSION['username'];
				$options .= "<input type=\"hidden\" name=\"username\" value=\" ".$username." \"> \n";
				$options .= "<input type=\"hidden\" name=\"vote_flag\" value=\" ".$votes['vote_flag']." \"> \n";
				foreach ($option_values as $key => $option_value)
				{
					$key++;
					$options .= "<p ><input type=\"radio\" name=\"vote\" value=$key > $option_value</p>\n";
				}
				$options .= "<button style=\"margin: 20px; padding:5px 10px;\">Submit</button>\n";
				$options.="</form>\n";
			}
			if($users['voted_'.trim($votes['vote_flag'])]==1)
			{
				$options.="<p>You have already voted. Current results:</p>\n";
				$count=0;
				foreach ($option_values as $key => $option_value)
				{
					$key++;
					$sql = "SELECT count(vote) as count_$key FROM vote_records WHERE vote_id=".$votes['vote_id']." AND vote=$key";
					$count_result = $mysqli->query($sql);
					if(!$count_result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
					$vote_records = $count_result->fetch_assoc();
					$options.="<p>".$option_value.": ".$vote_records['count_'.$key]."</p>\n";
					$count += $vote_records['count_'.$key];
					$count_result->free();
				}
				$options.="<p>Total number of votes: ".$count."</p>\n";
			}
			echo $options;
		}
		$votes_result->free();
	}
	else echo "<p>You can't vote yet.</p>\n";
	$users_result->free();
?>

<p><span id="error"><?php echo "$error"; ?></span></p> <!--Hibaüzenet kiiratás-->
		
<h1>Closed votes</h1>
<?php
	$sql = sprintf("SELECT * FROM votes WHERE is_active=0 ORDER BY create_date DESC"); 
	$votes_result = $mysqli->query($sql);
	$it = 1;
	while ($votes = $votes_result->fetch_assoc()) 
	{
		echo "<br><hr><h2 style=\"padding-top:0px;margin-bottom:0px;\">".$votes['vote_title_hu']."</h2>\n";
		echo "<h3>".$votes['vote_title_en']."</h3>\n";
		echo "<h4>Created: ".$votes['create_date']." (".$votes['creator'].")</h4>\n";
		$options="<p>Results:</p>\n";
		$option_values = explode("\n",$votes['vote_options']);
		$count=0;
		foreach ($option_values as $key => $option_value)
		{
			$key++;
			$sql = "SELECT count(vote) as count_$key FROM vote_records WHERE vote_id=".$votes['vote_id']." AND vote=$key";
			$count_result = $mysqli->query($sql);
			if(!$count_result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
			$vote_records = $count_result->fetch_assoc();
			$options.="<p>".$option_value.": ".$vote_records['count_'.$key]."</p>\n";
			$count_result->free();
			$count += $vote_records['count_'.$key];
			$count_result->free();
		}
		$options.="<p>Total number of votes: ".$count."</p>\n";
		echo $options;
	} 
	$votes_result->free();
?>
</div>
