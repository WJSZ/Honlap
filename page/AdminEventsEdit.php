<?php 

$error='';
$cim='';
$absztrakt='';
$szoveg='';
$hirid='';

if(isset($_GET['hirid']))
{
	$hirid = $_GET['hirid'];
	$sql = sprintf('SELECT cim, absztrakt, szoveg FROM hir WHERE hirid = %d',$hirid);
	$result = $mysqli->query($sql);
	$data = $result->fetch_assoc();
	$cim = $data['cim'];
	$absztrakt = $data['absztrakt'];
	$szoveg = $data['szoveg'];
}

if($_POST) // Szöveg frissítése
{
	if(isset($_POST['cim'])){ $cim = $mysqli->real_escape_string($_POST['cim']); }
	if(isset($_POST['absztrakt'])){ $absztrakt = $mysqli->real_escape_string($_POST['absztrakt']); }
	if(isset($_POST['szoveg'])){ $szoveg = $mysqli->real_escape_string($_POST['szoveg']); }
	if($_POST['hirid'] != '')
	{	
		$sql = sprintf("UPDATE hir SET cim='%s', absztrakt ='%s', szoveg ='%s', szerzo='%s' WHERE hirid ='%d'", $cim, $absztrakt, $szoveg, $_SESSION['username'], $_POST['hirid']);
		$mysqli->query($sql);
	}
	if($_POST['hirid'] == '')
	{
		$sql = sprintf("INSERT INTO hir SET cim='%s', absztrakt ='%s', szoveg ='%s', szerzo='%s'", $cim, $absztrakt, $szoveg, $_SESSION['username']);
		$mysqli->query($sql);
	}	
	header('Location: '.$home.'Admin/Events/'); 
}
?>
<style type="text/css">
.CodeMirror {
      resize: both;
      overflow: auto !important;
    }
</style>
<div id="content">
<h1>Edit event</h1>

<p><span id="error"><?php echo "$error"; ?></span></p> <!--Hibaüzenet kiiratás-->

<!--<p><button type="button" onclick="WrapSwitch()" style="padding:3px 10px 3px 10px;">Sortörés</button></p>-->

<form id="profil" class="bigform center" action="" method="post" style="margin-left:-100px">
	<input type="hidden" name="hirid" value="<?php echo $hirid ?>"/>
	<p style="margin-left:100px"><button id="button">Save</button></p>
	<p style="text-align:left"><button type="button" onclick="WrapSwitch()" style="padding:3px 10px 3px 10px;">Linebreak</button></p>
	<p>
		<label>Title (max 1000 character):</label>
		<textarea id="hircim" name="cim" autocomplete="off" autofocus /><?php echo $cim ?></textarea>
	</p>
	<p>
		<label>Abstract (max 1000 character):</label>
		<textarea id="absztrakt" name="absztrakt" /><?php echo $absztrakt ?></textarea>
	</p>
	<p>
		<label>Content: </label>
		<textarea id="szoveg" name="szoveg" /><?php echo $szoveg ?></textarea>
	</p>
</form>
</div>

<script type="text/javascript">

var editor1 = CodeMirror.fromTextArea(document.getElementById("hircim"), {
	mode: 'application/x-httpd-php',
	lineNumbers: true,
	lineWrapping: true,
	styleActiveLine: true,
	matchBrackets: true,
	smartIndent: false,
	tabSize: 4,
	theme: 'eclipse',
	height: '500px'
  });

  editor1.setSize(800, 100);
  var editor2 = CodeMirror.fromTextArea(document.getElementById("absztrakt"), {
	mode: 'application/x-httpd-php',
	lineNumbers: true,
	lineWrapping: true,
	styleActiveLine: true,
	matchBrackets: true,
	smartIndent: false,
	tabSize: 4,
	theme: 'eclipse',
	height: '300px'
  });
  editor2.setSize(800, 300);
  var editor3 = CodeMirror.fromTextArea(document.getElementById("szoveg"), {
	mode: 'application/x-httpd-php',
	lineNumbers: true,
	lineWrapping: true,
	styleActiveLine: true,
	matchBrackets: true,
	smartIndent: true,
	tabSize: 4,
	theme: 'eclipse',
	height: '600px'
  });
  editor3.setSize(800, 600);
  
  // Wrap set
var wrap=false;
function WrapSwitch(){
	editor1.setOption("lineWrapping", wrap);
	editor2.setOption("lineWrapping", wrap);
	editor3.setOption("lineWrapping", wrap);
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