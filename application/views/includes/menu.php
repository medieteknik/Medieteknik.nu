<?php
echo '
<nav id="main-navigation" class="clearfix">
	<ul>
		<li>', anchor("news",$menu_news), '</li>
		<li>', anchor("about",$menu_about), '</li>
		<li>', anchor("association",$menu_association), '</li>
		<li>', anchor("mtd", $menu_mtd), '</li>
		<li>', anchor("forum",$menu_forum), '</li>
		<li>', anchor(substr(site_url(), 0, -2).'se'.uri_string(), $misc_swedish_native), '</li>
		<li>', anchor(substr(site_url(), 0, -2).'en'.uri_string(), $misc_english_native), '</li>';
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
<li>', anchor("test", 'Test'), '</li>
<li>', anchor("http://wiki.medieteknik.nu/",$menu_wiki), '</li>
*/