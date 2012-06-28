<nav id="main-navigation" class="clearfix">
	<ul>
		<li><?php echo anchor("news",$menu_news);?></li>
		<li><?php echo anchor("forum",$menu_forum);?></li>
		<li><a>Wiki</a></li>
		<?php
		echo '<li><a href="'.substr(site_url(), 0, -2).'se'.uri_string().'">'.$misc_swedish.'</a></li>';
		echo '<li><a href="'.substr(site_url(), 0, -2).'en'.uri_string().'">'.$misc_english.'</a></li>';
		
		if($this->login->is_logged_in()) {
			echo '<li>'.anchor('user/logout',$menu_logout).'</li>';
		} else {
			echo '<li>'.anchor('user/login',$menu_login).'</li>';
		}
		if($this->login->is_admin()) {
			echo '<li>'.anchor('admin',$menu_admin).'</li>';
		}
		
		?>
	</ul>
</nav>

<?php

/*
<li><?php echo anchor("news",$menu_news);?></li>
		<li><a>Arkiv</a></li>
		<li><a>Om utbildningen</a></li>
		<li><a>Om sektionen</a></li>
		<li><a>Studentliv</a></li>
		<li><a>MT-Studenter</a></li>
		<li><?php echo anchor("forum",$menu_forum);?></li>
		<li><a>Wiki</a></li>
		<li><a>Företag</a></li>

*/

?>
