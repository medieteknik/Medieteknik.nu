<header>
	<?php 
	echo anchor_img('main', '', 'web/img/logo.png', 'Logo');
	?>
	<br/>
	<br/>
	<?php
	
	echo '<a href="'.substr(site_url(), 0, -2).'se'.uri_string().'">Svenska</a><br>';
	echo '<a href="'.substr(site_url(), 0, -2).'en'.uri_string().'">English</a><br>';
	
	?>
</header>