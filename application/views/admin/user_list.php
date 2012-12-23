<?php

$this->table->set_heading(array($lang['user_userid'], $lang['user_lukasid'], $lang['user_name'], ''));
$this->table->set_empty("&nbsp;");


$totalpages = (floor($user_num / $currentview['rowsperpage']) + 1);

foreach ($user_list as $user)
{
	// if user is disabled, tell the visitor
	if($user->disabled)
		$user_name = get_full_name($user).'
		<span class="smallnotice red" title="'.$lang['user_disabled_exp'].'">'.$lang['user_disabled'].'</span>';
	else
		$user_name = get_full_name($user);

	// add user row to table
	$user = array($user->id, $user->lukasid, $user_name, anchor('admin_user/edit_user/'.$user->id, '<i class="-icon-pen"></i>', ' title="'.$lang['admin_edituser'].'"'));
	$this->table->add_row($user);
}

echo '
<div class="main-box clearfix profile">
	<h2>'.$lang['user_overview'].'</h2>';
	echo $this->table->generate();
	echo '<p>'.$lang['misc_page'].' '.($currentview['page'] + 1).' '.$lang['misc_of'].' '.$totalpages.'</p>';
echo'</div><!-- close .main-box -->';
?>
