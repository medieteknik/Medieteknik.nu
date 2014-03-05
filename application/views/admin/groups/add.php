<?php

$startyear = array(
              'id'          => 'startyear',
              'name'        => 'startyear',
              'maxlength'   => '4',
              'size'        => '50',
            );
$stopyear = array(
              'id'          => 'stopyear',
              'name'        => 'stopyear',
              'maxlength'   => '4',
              'size'        => '50',
            );

if(isset($status))
{
	if(!$status)
	{
		echo $status;
		echo '<p class="notice red"><strong>'.$lang['error_error'].'</strong> ';
		echo '</p>';

		//echo '<p class="notice">'.$lang['admin_addusers_success'].' '.anchor('admin_user/edit_user/'.$entered['lid'], $lang['admin_edituser']).'</p>';
	}
	else{
		//echo '<p class="notice">'.$lang['admin_addusers_success'].' '.anchor('admin_groups/edit/'.$group_id, $lang['admin_edituser']).'</p>';
		redirect('admin/groups/edit/'.$group_id, 'refresh');
	}

}

echo
form_open_multipart('admin/groups/add_year/'.$group_id.'/create'),
'<div class="main-box clearfix"><h2>', $lang['admin_groups_add_year'], '</h2>';


echo form_label($lang['admin_groups_startyear'], 'startyear'),
	form_input($startyear),
	form_label($lang['admin_groups_stopyear'], 'stopyear'),
	form_input($stopyear),
	form_submit('save', $lang['misc_save']),
form_close(),
'</div><!-- close .main-box -->';
?>
