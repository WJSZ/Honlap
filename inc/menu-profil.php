<nav id="menu">
	<ul>
		<?php if(isset($_SESSION['admin'])) { ?> 
		<li><a href="Admin/Users/">Admin</a>
			<ul>
				<li><a href="Admin/Users/">Users</a></li>
				<li><a href="Admin/Events/">Events</a></li>
				<li><a href="Admin/Votes/">Votes</a></li>
				<li><a href="Admin/Members/">Members</a></li>
				<li><a href="Admin/Website/">Website</a></li>
			</ul>
		</li> 
		<?php } ?>
		<li><a href="Tag/Vote/">Vote</a></li>
		<li><a href="Tag/Calendar/">G Calendar</a></li>
		<li><a href="https://drive.google.com/drive/folders/0Bw5YzjirRUotbWstZDJWV21fTkk?usp=sharing" target=blank>G Drive</a></li>
		<li><a href="https://www.facebook.com/groups/432167953900461/?multi_permalinks=901549896962262&notif_id=1587932066902803&notif_t=group_activity&ref=notif" target=blank>FB group</a></li>
		<li><a href="https://wignerjenszakkollgium.slack.com/" target=blank> Slack </a></li>
		<!--<li><a href="https://wjsz.bme.hu/~kiskor/wiki/Kezd%C5%91lap" target=blank> KisKör Wiki </a></li>-->
		<li><a href="Tag/Profile/">Profile</a></li>
	</ul>
</nav>
