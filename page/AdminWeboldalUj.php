<?php

// DECLARATION
$listpos = isset($_GET['listpos']) ? $_GET['listpos'] : 0;
$sublistpos = isset($_GET['sublistpos']) ? $_GET['sublistpos'] : 0;

$user = $_SESSION['username'];

$text=array();
$mainmenuchecked = '';
$submenuchecked = '';
$hu_name = '';
$eng_name = '';
$targetcheck = '';
$stylecheck = '';
$hu_content = '';
$eng_content = '';
$hu_content_back = '';
$eng_content_back = '';
$error = '';
$href = '';
$location = '';
$N_checked='';
$T_checked='';
$A_checked='';

if($listpos){ // EDIT PAGE
	$text['gomb-title'] = 'Gomb módosítása';
	$text['tartalom-title'] = 'Tartalom szerkesztése';
	$text['button'] = 'Oldal mentése';
	
	$sql = sprintf("SELECT * FROM menu WHERE listpos = %s AND sublistpos = %s",$listpos,$sublistpos);
	$data = $mysqli->query($sql)->fetch_assoc();
	
	$href = $data['href'];
	$location = $data['location'];
	$old_location = $location;
	
	$sql = sprintf("SELECT * FROM content WHERE location = '%s'",$location);
	$content = $mysqli->query($sql)->fetch_assoc();
	$hu_content = $content['hu_content'];
	$eng_content = $content['eng_content'];
	$hu_content_back = $content['hu_content'];
	$eng_content_back = $content['eng_content'];
	/*
	switch ($content['priv']){
		case 'N': $N_checked='checked';break;
		case 'T': $T_checked='checked';break;
		case 'A': $A_checked='checked';break;
	}*/
	
	// FELIRATOK
	$hu_name = $data['hu_name'];
	$eng_name = $data['eng_name'];
	
	// ATTRIBUTUMOK
	if($data['target']) $targetcheck = 'checked';
	if($data['style']) $stylecheck = 'checked';
	
	// LISTA POZICIO
	$ListPosOpts = '';
	if($sublistpos){
		$submenuchecked = 'checked';// MENU POZICIO
		$sql = sprintf("SELECT count(*) AS count_sublistpos FROM menu WHERE listpos = ".$listpos);
		$count_sublistpos = $mysqli->query($sql)->fetch_object()->count_sublistpos;
		for($i = 1;$i<$count_sublistpos;$i++){
			if ($i == $sublistpos) $selected = 'selected';
			else $selected='';
			$ListPosOpts .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
		}
	}
	else{
		$mainmenuchecked = 'checked';// MENU POZICIO
		$sql = sprintf("SELECT count(*) AS count_listpos from (select * from menu group by listpos) AS view");
		$count_listpos = $mysqli->query($sql)->fetch_object()->count_listpos;
		for($i = 1;$i<$count_listpos;$i++){
			if ($i == $listpos) $selected = 'selected';
			else $selected='';
			$ListPosOpts .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
		}
	}
}
else{ // NEW PAGE
	$text['gomb-title'] = 'Új gomb';
	$text['tartalom-title'] = 'Új tartalom';
	$text['button'] = 'Oldal létrehozása';
	$N_checked='checked';
}

if(isset($_POST['newMenu'])){
	// POST DATA CHECKS
	if(!isset($_POST['menuCheck'])){
		$error .= '<li>Nincs kiválasztva menü pozíció!</li>';
		}
		else {
		$menuCheck = $_POST['menuCheck'];	
		if($menuCheck == 'main'){
			$mainmenuchecked = 'checked';
			$submenuchecked = '';		
		}
		if($menuCheck == 'sub'){
			$mainmenuchecked = '';
			$submenuchecked = 'checked';
		}
		if($menuCheck == 'sub' && !isset($_POST['selectedMainMenu'])) {
			$error .= '<li>Nincs kiválasztva melyik főmenü alá kerüljön a gomb!</li>';
			}
		if(isset($_POST['selectedMainMenu'])){
			$selectedMainMenu = $_POST['selectedMainMenu'];
			}
		}
	if(!$_POST['hu_name']){
		$error .= '<li>Nincs megadva a gomb magyar felirata!</li>';
		}/*
		elseif(strpos($_POST['hu_name'],'.') !== false){
		$error .= '<li>Nem szerepelhet pont a magyar feliratban!</li>';
		}*/
		else{
		$hu_name = $mysqli->real_escape_string($_POST['hu_name']);
		}
	if(!$_POST['eng_name']){
		$error .= '<li>Nincs megadva a gomb angol felirata!</li>';
		}
		else{
		$eng_name = $mysqli->real_escape_string($_POST['eng_name']);
		}
}

// FŐMENÜ ÉS LISTA POZÍCIÓ OPCIÓK
$MainMenuOpts = '<option value="0">...</option>';
$sql = sprintf("SELECT * FROM menu WHERE sublistpos = 0 AND listpos != 0 ORDER BY listpos");
$pages = $mysqli->query($sql);
echo "
<script>
function get_sublist_count(){
  var sublist_count = [$listpos];\n"; // tömb 0. eleme a $_GET['listpos']
while($row = $pages->fetch_assoc()){
	// FŐMENÜ
	if (!isset($selectedMainMenu)) $selectedMainMenu = 0;
	if ($selectedMainMenu == $row['listpos']){
		$selected='selected';
		$main_hu_name = $row['hu_name'];
	}
	elseif($listpos == $row['listpos']){
		$selected='selected';
	}
	else $selected = '';
	$MainMenuOpts .= '<option value="'.$row['listpos'].'" '.$selected.'>'.$row['hu_name'].'</option>';
	
	// LISTA POZÍCIÓ
	$sql = sprintf("SELECT count(*) AS count_sublistpos FROM menu WHERE listpos = ".$row['listpos']);
	$count_sublistpos = $mysqli->query($sql)->fetch_object()->count_sublistpos;
	$lol = $row['listpos'];
	echo "  sublist_count[$lol] = $count_sublistpos;\n";
}
echo "
return sublist_count;}
</script>\n";

// EGYEDI LINK OPCIÓK
$LinksOpts = '';
$locations = array();
$sql = sprintf("SELECT location FROM menu WHERE listpos != 0 ORDER BY listpos, sublistpos");
$result = $mysqli->query($sql);
while( $row = $result->fetch_object() ){
	$locations[$row->location] = $row->location; 
	$LinksOpts .= '<option>'.$row->location."</option>\n";
}
if(isset($_POST['newMenu'])){
	if(!$error){
		// POST DECLARATIONS
		$href='';
		$target='';
		$style='';
		if($menuCheck == 'main') $location = replace_accented_chars($hu_name).'/';
		if($menuCheck == 'sub') $location = replace_accented_chars($main_hu_name).'/'.
		                                    replace_accented_chars($hu_name).'/';
		if($_POST['href']) $href=$mysqli->real_escape_string($_POST['href']);
		else $href = $location;
		if(isset($_POST['target'])) $target='blank';
		if(isset($_POST['style'])) $style='display:none;';
		if(isset($_POST['selectedListPos'])) $selectedListPos=$_POST['selectedListPos'];
		$hu_content = $mysqli->real_escape_string($_POST['code1']);
		$eng_content = $mysqli->real_escape_string($_POST['code2']);
		$hu_content_back = $_POST['code1'];
		$eng_content_back = $_POST['code2'];
		/*
		$priv = $_POST['priv'];
		switch ($priv){
			case 'N': $N_checked='checked';$T_checked='';$A_checked='';break;
			case 'T': $T_checked='checked';$N_checked='';$A_checked='';break;
			case 'A': $A_checked='checked';$N_checked='';$T_checked='';break;
		}
		*/
		if($listpos){ // EDIT PAGE POST
			if($menuCheck=='main'){
				// LISTPOS SETTINGS
				$sql = sprintf("SELECT count(*) AS count_listpos FROM (SELECT * FROM menu GROUP BY listpos) AS view");
				$max_listpos = $mysqli->query($sql)->fetch_object()->count_listpos+1;
				$from = $listpos;
				$to = $selectedListPos;
				$count = 0;
				$iter = $from - $to;
				$sign = sign($iter);
				$sql = sprintf("UPDATE menu 
				                SET listpos = %s 
								WHERE listpos = %s;",
								$max_listpos, $from);
				while($count<abs($iter)){
					$from -= $sign;
					$move = $from + $sign;
					$sql2 = sprintf("UPDATE menu
									 SET listpos = %s
									 WHERE listpos = %s;",
									 $move, $from);
					$sql .= $sql2;
					$count++;
				}
				$sql2 = sprintf("UPDATE menu
				                 SET listpos = %s
								 WHERE listpos = %s;",
								 $to,$max_listpos);
				$sql .= $sql2;
				
				// DB UPDATE	
				
				//$sql_location='';if($location != $old_location) $sql_location = "location = '".$location."',";

				$sql2 = sprintf("UPDATE menu 
								SET hu_name = '%s', 
								    eng_name = '%s', 
									location = '%s', 
									href = '%s', 
									target = '%s', 
									style = '%s'
								  WHERE listpos = %s
								  AND sublistpos = 0;",
								$hu_name, $eng_name, $location, $href, $target, $style,
								$to);
				$sql .= $sql2;
				$sql2 = sprintf("UPDATE content
								 SET location = '%s', 
								     hu_content = '%s', 
									 eng_content = '%s',
									 mod_user = '%s',
									 mod_dat = NOW()
								  WHERE location = '%s';",
								$location, $hu_content, $eng_content, $user, /*$priv,*/
								$old_location);
				$sql .= $sql2;
				$sql2 = sprintf("SELECT location FROM menu WHERE listpos != 0 ORDER BY listpos, sublistpos");
				$sql .= $sql2;

				if($mysqli->multi_query($sql)){
					$error .= 'Szerkesztés sikeres volt!<br>';
					$done = 1;
				}
				else $error .= $mysqli->errno.'<br>'.$mysqli->error."<br>SQL: ".htmlspecialchars($sql).'<br>';
			}
			if($menuCheck=='sub'){
				// SUBLISTPOS SETTINGS
				$sql = sprintf("SELECT count(*) AS count_sublistpos FROM menu WHERE listpos = ".$selectedMainMenu);
				$max_sublistpos = $mysqli->query($sql)->fetch_object()->count_sublistpos;
				$from = $sublistpos;
				$to = $selectedListPos;
				$count = 0;
				$iter = $from - $to;
				$sign = sign($iter);
				$sql = sprintf("UPDATE menu 
				                SET listpos = %s, sublistpos = %s 
								WHERE listpos = %s 
								AND sublistpos = %s;",
								$selectedMainMenu, $max_sublistpos, 
								$listpos, 
								$from);
				while($count<abs($iter)){
					$from -= $sign;
					$move = $from + $sign;
					$sql2 = sprintf("UPDATE menu
									 SET sublistpos = %s
									 WHERE listpos = %s
									 AND sublistpos = %s;",
									 $move, $selectedMainMenu, $from);
					$sql .= $sql2;
					$count++;
				}
				$sql2 = sprintf("UPDATE menu
				                 SET sublistpos = %s
								 WHERE listpos = %s
								 AND sublistpos = %s;",
								 $to, $selectedMainMenu, $max_sublistpos);
				$sql .= $sql2;
				// DB UPDATE
				$sql2 = sprintf("UPDATE menu 
								SET hu_name = '%s', 
								    eng_name = '%s', 
									location = '%s', 
									href = '%s', 
									target = '%s', 
									style = '%s'
								  WHERE listpos = %s
								  AND sublistpos = %s;",
								$hu_name, $eng_name, $location, $href, $target, $style,
								$selectedMainMenu, $to);
				$sql .= $sql2;
				$sql2 = sprintf("UPDATE content
								 SET location = '%s', 
								     hu_content = '%s', 
									 eng_content = '%s',
									 mod_user = '%s',
									 mod_dat = NOW()
								  WHERE location = '%s';",
								$location, $hu_content, $eng_content, $user,/*$priv,*/
								$old_location);
				$sql .= $sql2;
				if($mysqli->multi_query($sql)){
					$error .= 'Szerkesztés sikeres volt!<br>';
					$done = 1;
				}
				else $error .= $mysqli->errno.'<br>'.$mysqli->error."<br>SQL: ".htmlspecialchars($sql).'<br>';
			}
			
			if($done) $locations[$old_location] = $location;
		}
		else{ // NEW PAGE POST
			// LISTPOS SETTINGS
			if($menuCheck == 'main'){
				$sql = sprintf("SELECT count(*) AS count_listpos FROM (SELECT * FROM menu GROUP BY listpos) AS view");
				$new_listpos = $mysqli->query($sql)->fetch_object()->count_listpos;
				$new_sublistpos = 0;
			}
			if($menuCheck == 'sub'){
				$new_listpos = $selectedMainMenu;
				$sql = sprintf("SELECT count(*) AS count_sublistpos FROM menu WHERE listpos = ".$new_listpos);
				$new_sublistpos = $mysqli->query($sql)->fetch_object()->count_sublistpos;
			}
			// DB WRITE
			$sql = sprintf("INSERT INTO menu 
			                  (listpos, sublistpos, hu_name, eng_name, location, href, target, style)
							  VALUES (%s, %s, '%s', '%s', '%s', '%s', '%s', '%s');
							INSERT INTO content
							  (location, hu_content, eng_content, cr_user)
							  VALUES ('%s','%s','%s', '%s');",
							$new_listpos, $new_sublistpos, $hu_name, $eng_name, $location, $href, $target, $style,
							$location, $hu_content, $eng_content, $user/*, $priv*/);
			if($mysqli->multi_query($sql)){
				$error = 'Új gomb és tartalom felvétele sikeres!';
				$done = 1;
				$locations[$location] = $location;
			}
			elseif($mysqli->errno == '1062') $error = 'Már létezik ez a gomb';
			else $error = $mysqli->errno.'<br>'.$mysqli->error."<br>SQL: ".$sql;
		}
	}
}

// $href nullázás, ha módosítjuk a gomb nevét, a linkje is változzon
if($href == $location) $href='';

$vissza = '<br><u><a href="Admin/Weboldal/" style="text-align:center;"> < < vissza</a></u>';
if($error) echo $errorDIV.$error.$vissza.'</div>';

?>

<div id="content">
<h1><?=$text['gomb-title']?></h1>

<form method="post" action="" style="margin-top:20px;">
	<p style="margin:0px;float:right;">(* kötelező)</p>
	<p>* Gomb magyar felirata:</p>
		<div class="center">
			<input name=hu_name
				   type="text" size="20" 
				   autocomplete="off"
				   value="<?=$hu_name?>">
		</div>
	<p>* Gomb angol felirata:</p>
		<div class="center">
			<input name=eng_name 
			       type="text" 
				   size="20" 
				   autocomplete="off"
				   value="<?=$eng_name?>">
		</div>
	
	<hr style="margin:20px 0px 10px 0px;">
	
	<p style="margin-top:0px">* Menü pozíció:</p>
	<div class="center"><p style="margin:0">
		<?php if(!$sublistpos && $listpos || !$listpos) : ?>
			<input name=menuCheck id=main type="radio" value="main" <?=$mainmenuchecked?>>
				<label for=main class="cursoru">Főmenü sorban</label><br>
		<?php endif; if ($sublistpos && $listpos || !$listpos) :?>
			<input name=menuCheck id=sub type="radio" value="sub" <?=$submenuchecked?>>
				<label for=sub class="cursoru">Almenü a 
					<select name=selectedMainMenu 
							onChange="changeListPosOpts(this.value)">
							<?=$MainMenuOpts?>
					</select>
				-főmenü alatt</label>
		<?php endif; ?>
	</p></div>
	<?php if ($listpos) : ?>
	<p>Lista pozíció:</p>
		<div class="center">
			<select id=selectedListPos name=selectedListPos><?=$ListPosOpts?></select>
		</div>
	<?php endif; ?>
	<?php /* 
	<p>Jogosultság:</p>
		<div class="center"><p>
			<input name=priv id=N type="radio" value="N" <?=$N_checked?>>
				<label for=N class="cursoru">Normál (bárki számára)</label></br>
			<input name=priv id=T type="radio" value="T" <?=$T_checked?>>
				<label for=T class="cursoru">Tag (bejelentkezett tagok számára)</label></br>
			<input name=priv id=A type="radio" value="A" <?=$A_checked?>>
				<label for=A class="cursoru">Admin (bejelentkezett admin tagok számára</label></br>
		</div></p>
	*/ ?>
	<hr style="margin:20px 0px 10px 0px;">
	
	<p>Egyedi link létrehozása:</p>
		<div class="center">
			<input name=href 
			       type="text" 
				   size="40" 
				   autocomplete="off"
				   list="links"
				   value="<?=$href?>">
			<datalist id="links">
				<?=$LinksOpts?>
			</datalist>
		</div>
	<p>Új böngésző lapot nyisson? (target="blank"):</p>
		<div class="center">
			<input name=target type="checkbox" <?=$targetcheck?>>
		</div>
	<p>Legyen rejtett? (style="display:none", <br><i>TÖRLÉS HELYETT, ha törölni szeretnéd kérlek jelezd az adminnnak</i>):</p>
		<div class="center">
			<input name=style type="checkbox" <?=$stylecheck?>>
		</div>
</div>

<div style="max-width:1250px;margin:auto;">
<h1><?=$text['tartalom-title']?></h1>
	<?php if($listpos) : ?>
		<p>location: <input type="text" value="<?=$location?>" readonly></p>
	<?php endif; ?>
	<p><button type="button" onclick="WrapSwitch()" style="padding:3px 10px 3px 10px;">Sortörés</button></p>
	<div style="display:inline;float:left;margin-left:10px">
		<p>Magyar tartalom:</p>
		<textarea id="code1" name=code1><?=$hu_content_back?></textarea>
	</div>
	<div style="display:inline;float:left;margin-left:10px;">
		<p>English content:</p>
		<textarea id="code2" name=code2><?=$eng_content_back?></textarea>
	</div>
	<p class="floatclear">Válassz témát: 
		<select id="select" onchange="selectTheme()">
			<option selected>eclipse</option>
			<?=$CodeMirrorThemes?>
		</select>
	</p>
	<div class="center" style="position:fixed;
	                           bottom:0;
							   width:200px;
							   left:42%;
							   padding:8px;
							   border:2px solid black;
							   border-radius: 10px;
							   background-color:#05196e;
							   z-index:1000">
		<button name=newMenu style="padding:8px 18px 8px 18px;"><?=$text['button']?></button>
	</div>
</form>
</div>

<script type="text/javascript">
// Főmenü választás hatására lista pozíció beállítás
function changeListPosOpts(selectedMainMenu){
	document.getElementById('sub').checked = true;
	var ListPosOpts = document.getElementById('selectedListPos');
	var sublist_count = get_sublist_count();
	if (selectedMainMenu == sublist_count[0]){ // ha a kiválsztott főmenü megyegyezik a gomb eredeti főmenüjével, akkor az iteráció egyel kisebb kell legyen, különben a saját főmenüjében egyel több lista pozíció lesz
		var iter = sublist_count[selectedMainMenu];
	}
	else{
		var iter = sublist_count[selectedMainMenu] + 1;
	}
	var options = '';
	for (var i = 1; i < iter; i++){
		var options = options + "<option>" + i + "</option>";
		
	}
	ListPosOpts.innerHTML = options;
}

var editor1 = CodeMirror.fromTextArea(document.getElementById("code1"), {
	mode: 'application/x-httpd-php',
	lineNumbers: true,
	lineWrapping: false,
	styleActiveLine: true,
	matchBrackets: true,
	smartIndent: false,
	tabSize: 4,
	theme: 'eclipse',
	height: '500px'
  });
  editor1.setSize(600, 600);

var editor2 = CodeMirror.fromTextArea(document.getElementById("code2"), {
	mode: 'application/x-httpd-php',
	lineNumbers: true,
	lineWrapping: false,
	styleActiveLine: true,
	matchBrackets: true,
	smartIndent: false,
	tabSize: 4,
	theme: 'eclipse',
	height: '500px'
  });
  editor2.setSize(600, 600);

  // Wrap set
var wrap=true;
function WrapSwitch(){
    editor1.setOption("lineWrapping", wrap);
	editor2.setOption("lineWrapping", wrap);
	wrap = !wrap;
}
  
  // Theme set
  var input = document.getElementById("select");
  function selectTheme() {
    var theme = input.options[input.selectedIndex].innerHTML;
    editor1.setOption("theme", theme);
	editor2.setOption("theme", theme);
  }
  var choice = document.location.search &&
               decodeURIComponent(document.location.search.slice(1));
  if (choice) {
    input.value = choice;
    editor1.setOption("theme", theme);
	editor2.setOption("theme", theme);
  }
</script>
