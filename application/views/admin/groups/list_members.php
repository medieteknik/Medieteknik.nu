<?php

$this->table->set_heading(array($lang['user_name'], $lang['admin_groups_position'], 'Email', ''));
$this->table->set_empty("&nbsp;");

//do_dump($member_list);
foreach ($member_list as $member)
{
	// add user row to table
	$member = array(anchor("user/profile/".$member->user_id,$member->first_name." ".$member->last_name), $member->position, $member->email,
					anchor('admin/groups/edit_member/'.$groups_year_id.'/'.$group_id.'/'.$member->user_id,
					'<i class="-icon-pen"></i>', ' title="'.$lang['admin_groups_editmember'].'"'));
	$this->table->add_row($member);
}

echo '
<div class="main-box clearfix profile">
	<h2>'.$lang['admin_groups_editmembers'].anchor('admin/groups/edit/'.$group_id, '&larr; '.$lang['misc_back']).'</h2>
	<p>',anchor('admin/groups/add_member/'.$groups_year_id.'/'.$group_id, $lang['admin_addmemberbyclicking']),'</p>',
	(isset($_GET['confdel']) ? '<p class="notice">'.$lang['misc_done'].'</p>' : ''),
	$this->table->generate();

echo'</div><!-- close .main-box -->';

//Ta bort grupp
echo '
<div class="main-box news clearfix red">
<h2>',$lang['misc_delete'],'</h2>';
if(isset($groups_year_id))
	echo form_open('admin/groups/remove_year/'.$groups_year_id);
else
	echo form_open('admin/groups/remove_year');

echo form_submit('delete', 'Delete'),
form_close(),
'</div>
';
?>
