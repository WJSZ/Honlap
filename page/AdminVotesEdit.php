<?php 

/** VÁLTOZÓK DEKLARÁLÁSA **/

$voteid=0;
$newoptionid=1;
$error = ''; 
$options = '';
$vote_options = '';
$is_secret=1;

function get_next_flag($vote_flags)
{
	for ($i = 1; $i <= 10; $i++)
	{
		$good=1;
		foreach($vote_flags as $value)
		{
			if($value == $i) $good=0;
		}
		if($good) $next_flag = $i;
	}
	return $next_flag;
}

if (isset($_GET['voteid']) && !(isset($_POST['save']))) 
{ 
	$voteid = $_GET['voteid'];
	$sql = sprintf("SELECT * FROM votes WHERE vote_id = %d",$voteid); 
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) { 
		$vote_title_hu = $row['vote_title_hu'];
		$vote_title_en = $row['vote_title_en'];
		$vote_flag = $row['vote_flag'];
		$is_secret = $row['is_secret'];
		if($is_secret == 0) $selected = "selected";
		$option_values = explode("\n",$row['vote_options']);
		foreach ($option_values as $key => $option_value)
		{
			$key++;
			$options .= "<input id=input-$key type=text placeholder=\"Option $key\" name=$key value=\"".$option_value."\" style=\"display: block; margin: 20px;\">\n";
		}
		$newoptionid=++$key;
	}
}

if(isset($_POST['save']))
{
	if(isset($_POST['vote_title_hu'])) { $vote_title_hu = $_POST['vote_title_hu']; }
	if (isset($_POST['vote_title_en'])) { $vote_title_en = $_POST['vote_title_en']; }
	if (isset($_POST['is_secret'])) { $is_secret = $_POST['is_secret']; }
	if (isset($_GET['voteid'])) { $voteid = $_GET['voteid']; }
	$iter=1;
	while(isset($_POST["$iter"]))
	{
		$options .= "<input id=input-$iter type=text name=$iter value=\"".$_POST["$iter"]."\" style=\"display: block; margin: 20px;\">\n";
		$vote_options .= $_POST["$iter"]."\n";
		$iter++;
	}
	$newoptionid = $iter;

	/** ELLENŐRZÉSEK **/

	if($vote_title_hu == '' ) { $error .= 'Error: missing hungarian title!<br>\n';}
	/* Check the number of active votes */
	$sql = "SELECT count(vote_id) as count FROM `votes` WHERE is_active = 1";
	$result = $mysqli->query($sql);
	if(!$result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
	$data = $result->fetch_assoc();
	if($data['count'] >= 10 && $voteid==0) $error .= "Cannot create new vote, because the maximum number of active votes is 10. <br>\n";

	/** ADATBÁZIS ÍRÁS **/

	if($error == '') 
	{
		if($voteid) 
		{ 
			$command1 = "UPDATE"; 
			$command2 = sprintf("WHERE vote_id = '%d'",$voteid); 
			$sql = "SELECT vote_flag FROM `votes` WHERE vote_id = ".$voteid;
			$result = $mysqli->query($sql);
			if(!$result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
			$data = $result->fetch_assoc();
			$vote_flag = $data['vote_flag'];
		}
		else 
		{ 
			$command1 = "INSERT INTO"; 
			$command2 = "";
			$sql = "SELECT vote_flag FROM `votes` WHERE is_active = 1";
			$result = $mysqli->query($sql);
			if(!$result) $error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
			$i = 0;
			while($data = $result->fetch_assoc())
			{
				$vote_flags[$i] = $data['vote_flag'];
				$i++;
			}
			$vote_flag = get_next_flag($vote_flags);
		}

		$sql = sprintf("%s votes SET vote_title_hu = '%s', vote_title_en = '%s', vote_flag = %d, is_secret = %d, is_active=1, vote_options='%s', creator='%s' %s", $command1, $mysqli->real_escape_string($vote_title_hu), $mysqli->real_escape_string($vote_title_en), $vote_flag, $is_secret, trim($vote_options), $_SESSION['username'], $command2);
		$result = $mysqli->query($sql);
		if(!$result)
			$error.="Adatbázislekérdezési hiba: $mysqli->error <br>\n"; //Adatbázislekérdezés ellenőrzés
		if($error == '') header("Location: /Admin/Votes");
	}
}


?>



<div id="content" class=center>

<h1>Edit vote</h1>

<?php if(isset($done)) { ?> <span align="center"><p>The operation was successful. <u><a href="Admin/Votes/">Back to the votes</a></u> </span> <?php } ?>

<p><span id="error"><?php echo "$error"; ?></span></p> <!--Hibaüzenet kiíratás-->

	<form id="form" action="" method="post" style="text-align:left;}">

		<p style="text-align:center"><button id="save" name="save" style="padding:8px 18px 8px 18px;" >Save</button></p>
		<p>
			<label>HUN title: </label>
			<textarea name="vote_title_hu"  rows="2" cols="80" autocomplete="off" autofocus/><?=$vote_title_hu?></textarea>
		</p>
		<p>
			<label>ENG title: </label>
			<textarea name="vote_title_en"  rows="2" cols="80" autocomplete="off" autofocus/><?=$vote_title_en?></textarea>
		</p>
		<p>
			<label>Secret vote? </label>  
			<select name="is_secret">
					<option value=1>Yes</option>
					<option value=0 <?=$selected?>>No</option>
			</select>
		</p>
		<p>
			<label>Options: </label>  
			<button id="btn" type="button">New field</button>
			<?=$options?>
		</p>
		
		
	</form>
	<br>
</div>

<script type="text/javascript">
(function() {
  var counter = <?=$newoptionid?>;
  var btn = document.getElementById('btn');
  var form = document.getElementById('form');
  var addInput = function() {
    var input = document.createElement("input");
    input.id = 'input-' + counter;
    input.type = 'text';
    input.name = counter;
    input.autocomplete = 'off';
    input.style = 'display:block;margin:20px;';
    input.placeholder = 'Option ' + counter;
    form.appendChild(input);
    counter++;
  };
  btn.addEventListener('click', function() {
    addInput();
  }.bind(this));
})();
</script>