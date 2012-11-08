<?php

echo '
<div class="main-box clearfix profile">

	<h2>'.$lang['admin_edituser'].' <em>'.get_full_name($user).'</em> '.anchor('admin_user', '&larr; '.$lang['misc_back']).'</h2>
	<p></p>
</div><!-- close .main-box -->';
?>