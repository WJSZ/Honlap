<?php
$HTMLmenu = "<nav id=\"menu\">\r\n<ul>";
$sql = sprintf("SELECT * FROM menu WHERE sublistpos = 0 ORDER BY listpos");
$pages = $mysqli->query($sql);
while($row = $pages->fetch_assoc()){
	$html = sprintf("\r\n\t<li><a href=\"%s\" target=\"%s\" style=\"%s\">%s</a>",
	               $row['href'],$row['target'],$row['style'],$row[$lang.'_name']);
	$HTMLmenu .= $html;
	$sql = sprintf("SELECT * FROM menu WHERE sublistpos != 0 AND listpos = ".$row['listpos']." ORDER BY sublistpos");
	$subpages = $mysqli->query($sql);
	if($subpages->fetch_assoc()){
		$HTMLmenu .= "\r\n\t\t<ul>";
		$subpages = $mysqli->query($sql);
		while($subrow = $subpages->fetch_assoc()){
			$html = sprintf("\r\n\t\t<li><a href=\"%s\" target=\"%s\" style=\"%s\">%s</a></li>",
						   $subrow['href'],$subrow['target'],$subrow['style'],$subrow[$lang.'_name']);
			$HTMLmenu .= $html;
		}
		$HTMLmenu .= "\r\n\t\t</ul>";
	}
	$HTMLmenu .= "\r\n\t</li>";
}
$HTMLmenu .= "\r\n<ul>\r\n</nav>\n";
echo $HTMLmenu;
?>