<?php

$this->table->set_heading(array($lang['user_name'], $lang['admin_groups_position'], 'Email', ''));
$this->table->set_empty("&nbsp;");

//do_dump($member_list);
foreach ($member_list as $member)
{
	// add user row to table
	$member = array(anchor("user/profile/".$member->user_id,$member->first_name." ".$member->last_name), $member->position, $member->email, anchor('admin_groups/edit_member/'.$groups_year_id.'/'.$member->user_id, '<i class="-icon-pen"></i>', ' title="'.$lang['admin_edituser'].'"'));
	$this->table->add_row($member);
}

echo '
<div class="main-box clearfix profile">
	<h2>'.$lang['admin_groups_editmembers'].'</h2>
	<p>',anchor('admin_groups/add_member', $lang['admin_addmemberbyclicking']),'</p>',
	(isset($_GET['confdel']) ? '<p class="notice">'.$lang['misc_done'].'</p>' : ''),
	$this->table->generate();

echo'</div><!-- close .main-box -->';
?>
