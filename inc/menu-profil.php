<nav id="menu">
	<ul>
		<?php if(isset($_SESSION['admin'])) { ?> 
		<li><a href="Admin/Felhasznalok/">Admin</a>
			<ul>
				<li><a href="Admin/Felhasznalok/">Felhasználók</a></li>
				<li><a href="Admin/Hirek/">Események</a></li>
				<!--<li><a href="Admin/Esemenyek/">Események</a></li>-->
				<li><a href="Admin/Tagok/">Tagok</a></li>
				<li><a href="Admin/Weboldal/">Weboldal</a></li>
			</ul>
		</li> 
		<?php } ?>
		<li><a href="Tag/Profil/">Profil</a></li>
		<li><a href="https://drive.google.com/drive/folders/0Bw5YzjirRUotbWstZDJWV21fTkk?usp=sharing" target=blank>Drive</a></li>
		<!--<li><a href="Tag/Tagok/"> Tagok </a></li>-->
		<li><a href="https://wjsz.bme.hu/~kiskor/wiki/Kezd%C5%91lap" target=blank> KisKör Wiki </a></li>
		<li><a href="Tag/Naptar/">Naptár</a></li>
	</ul>
</nav>
