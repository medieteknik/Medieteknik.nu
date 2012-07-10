<?php
echo '
<nav id="main-navigation" class="clearfix">
	<ul>
		<li>', anchor("news",$menu_news), '</li>
		<li>', anchor("about",$menu_about), '</li>
		<li>', anchor("forum",$menu_forum), '</li>
		<li>', anchor("test", 'Test'), '</li>
		<li>', anchor("http://wiki.medieteknik.nu/",$menu_wiki), '</li>
		<li>', anchor(substr(site_url(), 0, -2).'se'.uri_string(), $misc_swedish), '</li>
		<li>', anchor(substr(site_url(), 0, -2).'en'.uri_string(), $misc_english), '</li>';
		
		
		if($this->login->is_admin()) {
			echo '<li>',anchor('admin',$menu_admin),'</li>';
		}
		if($this->login->is_logged_in()) {
			echo '<li>',anchor('user','Profil'),'</li>';
			echo '<li>',anchor('user/logout',$menu_logout),'</li>';
		} else {
			echo '<li>',anchor('user/login',$menu_login),'</li>';
		}
		
echo '		
	</ul>
</nav>

';



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
