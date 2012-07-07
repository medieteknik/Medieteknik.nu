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

echo '
<div class="main-box clearfix">
	<h2>Forumet</h2>
	<p>Inga flaggade inlägg</p>
	<p>Inga inlägg kräver godkännande</p>
</div>
<div class="main-box clearfix">
	<h2>Nyheter</h2>
	<p>1 nyhet behöver bli godkänd</p>
</div>
';
