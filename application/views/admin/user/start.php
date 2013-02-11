<?php

echo '
<div class="main-box clearfix profile">
	<h2>'.$lang['admin_editusers'].'</h2>
	<ul class="box-list">
		<li>'.anchor('admin_user/user_list', $lang['admin_listusers']).'</li>
		<li>'.anchor('admin_user/user_add', $lang['admin_addusers']).'</li>
		<li>'.anchor('admin_user/user_search', $lang['admin_searchusers']).'</li>
	</ul>

</div><!-- close .main-box -->';
?>
