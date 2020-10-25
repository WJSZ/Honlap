<?php 

$members_content = "<div id=content> \n";

if($lang=='hu') $members_content .= "\t <h1>A Szakkollégium tagjai</h1> \n"; 
if($lang=='eng')$members_content .= "\t <h1>Members of the College</h1> \n"; 


if($lang=='hu') $members_content .= "\t <h2 style=\"float:left;width:600px\">Elnökségi tagok</h2> \n"; 
if($lang=='eng')$members_content .= "\t <h2 style=\"float:left;width:600px\">Presidency</h2> \n"; 

	$sql = sprintf("SELECT * FROM members WHERE status_order < 3"); 
	$members_result = $mysqli->query($sql);
	while ($members_data = $members_result->fetch_assoc()) {
		$sql = sprintf("SELECT status_name FROM members_status WHERE status_order = %s",$members_data['status_order']); 
		$status_result = $mysqli->query($sql);
		$status_data = $status_result->fetch_assoc();
		$img_name = str_replace($ekezetek, $ekezetmentesek, $members_data['name']);
		$img_name.=".png";
		if(file_exists("pic/profil/".$img_name) == 0) $img_name = "_FANTOM.png";
		$members_content .= "
			<div class=tag><img src=\"pic/profil/".$img_name."\"/>
			<h3 class=elnok-tag-h3>".$members_data['name']."</h3>
			<p class=tag-p>".$status_data['status_name']."<br></div> \n";
	}

if($lang=='hu') $members_content .= "\t <h2 style=\"float:left;width:600px\">Munkacsoport vezetők</h2> \n"; 
if($lang=='eng')$members_content .= "\t <h2 style=\"float:left;width:600px\">Working group team leaders</h2> \n"; 

	$sql = sprintf("SELECT * FROM members WHERE status_order > 2 AND status_order < 7"); 
	$members_result = $mysqli->query($sql);
	while ($members_data = $members_result->fetch_assoc()) {
		$sql = sprintf("SELECT status_name FROM members_status WHERE status_order = %s",$members_data['status_order']); 
		$status_result = $mysqli->query($sql);
		$status_data = $status_result->fetch_assoc();
		$img_name = str_replace($ekezetek, $ekezetmentesek, $members_data['name']);
		$img_name.=".png";
		if(file_exists("pic/profil/".$img_name) == 0) $img_name = "_FANTOM.png";
		$members_content .= "
			<div class=tag><img src=\"pic/profil/".$img_name."\"/>
			<h3 class=elnok-tag-h3>".$members_data['name']."</h3>
			<p class=tag-p>".$status_data['status_name']."<br></div> \n";
	}

if($lang=='hu') $members_content .= "\t <h2 style=\"float:left;width:600px\">Aktív tagok</h2> \n"; 
if($lang=='eng')$members_content .= "\t <h2 style=\"float:left;width:600px\">Active members</h2> \n"; 

	$sql = sprintf("SELECT * FROM members WHERE status_order = 7 ORDER BY name"); 
	$members_result = $mysqli->query($sql);
	while ($members_data = $members_result->fetch_assoc()) {
		$members_content .= "\t\t  <div class=tag2><h3 class=tag-h3>".$members_data['name']."</h3></div> \n";
	}

if($lang=='hu') $members_content .= "\t <h2 style=\"float:left;width:600px\">Tiszteletbeli tagok</h2> \n"; 
if($lang=='eng')$members_content .= "\t <h2 style=\"float:left;width:600px\">Honorary Members</h2> \n"; 

	$sql = sprintf("SELECT * FROM members WHERE status_order = 8 ORDER BY name"); 
	$members_result = $mysqli->query($sql);
	while ($members_data = $members_result->fetch_assoc()) {
		$members_content .= "\t\t  <div class=tag2><h3 class=tag-h3>".$members_data['name']."</h3></div> \n";
	}

if($lang=='hu') $members_content .= "\t <h2  style=\"float:left;width:600px\">Alumni tagok</h2> \n"; 
if($lang=='eng')$members_content .= "\t <h2 style=\"float:left;width:600px\">Alumni Members</h2> \n"; 

	$sql = sprintf("SELECT * FROM members WHERE status_order = 9 ORDER BY name"); 
	$members_result = $mysqli->query($sql);
	$members_content .= "\t\t  <p style=\"float:left;\">";
	while ($members_data = $members_result->fetch_assoc()) {
		$members_content .= $members_data['name'].", ";
	}
	$members_content .= "</p> \n";

$members_content .= "</div>";

echo $members_content;
?>
