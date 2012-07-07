<?php
echo '	<div class="main-box clearfix">
			<h2>',$lang['menu_admin'],'</h2><ul>';
			foreach($privileges as $priv) {
				echo '<li>',$priv->privilege_name,' - ',$priv->privilege_description,'</li>';
				//echo '<pre>';
				//var_dump($priv);
				//echo '</pre>';
			}
		echo'</ul></div>';
