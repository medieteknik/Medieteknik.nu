<?php

echo '
<div class="main-box clearfix profile">
	<h2>'.$lang['user_overview'].'</h2><ul class="box-list width-50">';

	foreach ($user_list as $user) {
		echo '<li><strong>'.$user->id.'</strong> <em>'.$user->lukasid.'</em> '.get_full_name($user).' '.anchor('admin_user/edit_user/'.$user->id, $lang['admin_edituser'].' &rarr;').'</li>';
	}

echo'</ul></div><!-- close .main-box -->';
?>