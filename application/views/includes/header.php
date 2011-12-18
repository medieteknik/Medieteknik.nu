<header>
	<?php 
	echo anchor_img('main', '', 'web/img/logo.png', 'Logo');
	?>
	<br/>
	<br/>
	<?php
	
	echo '<a href="'.substr(site_url(), 0, -2).'se'.uri_string().'">Svenska [flagga?]</a><br>';
	echo '<a href="'.substr(site_url(), 0, -2).'en'.uri_string().'">English [flagga?]</a><br>';
	echo '<a href="#" title="En beskrivning vid mushover över att sidan är primärt på svenska och att valt språk endast visas då det är tillgängligt">?</a><br>';
	
	?>
</header>