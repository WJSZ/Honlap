<nav id="menu">
	<ul>
		<?php if(isset($_SESSION['admin'])) { ?> 
		<li><a href="Admin/Users/" target="_self">Admin</a>
			<ul>
				<li><a href="Admin/Users/" target="_self">Users</a></li>
				<li><a href="Admin/Events/" target="_self">Events</a></li>
				<li><a href="Admin/Votes/" target="_self">Votes</a></li>
				<li><a href="Admin/Members/" target="_self">Members</a></li>
				<li><a href="Admin/Website/" target="_self">Website</a></li>
			</ul>
		</li> 
		<?php } ?>
		<li><a href="Tag/Vote/" target="_self">Vote</a></li>
		<li><a href="Tag/Calendar/" target="_self">G Calendar</a></li>
		<li><a href="https://drive.google.com/drive/folders/0Bw5YzjirRUotbWstZDJWV21fTkk?usp=sharing">G Drive</a></li>
		<li><a href="https://www.facebook.com/groups/432167953900461/?multi_permalinks=901549896962262&notif_id=1587932066902803&notif_t=group_activity&ref=notif" >FB group</a></li>
		<li><a href="https://wignerjenszakkollgium.slack.com/" > Slack </a></li>
		<!--<li><a href="https://wjsz.bme.hu/~kiskor/wiki/Kezd%C5%91lap" target=blank> KisKör Wiki </a></li>-->
		<li><a href="Tag/Profile/" target="_self">Profile</a></li>
	</ul>
</nav>
