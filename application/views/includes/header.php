<?php

/*
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
*/
?>
<header id="main-header">
	<div class="wrapper">
		<?php 
		//echo anchor_img('main', '', 'web/img/mt-logo-header.png', array('id' => 'main-header-logo'));
		
		// <img id="main-header-logo" src="images/mt-logo-header.png"/>
		?>
		<img id="main-header-logo" src="<?php echo base_url(); ?>web/img/mt-logo-header.png"/>
		<h1>Civilingenjör i Medieteknik</h1>
		<h2>Tekniska högskolan vid Linköpings Universitet</h2>
	</div>
</header>