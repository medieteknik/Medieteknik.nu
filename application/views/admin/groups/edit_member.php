<?php

$member = $members[0];
do_dump($member);

if($member->user_id == 0)
	redirect('error_page/user/?msg=notfound-adm', 'refresh');

$position = array(
			'id'		=> 'position',
			'name'		=> 'position',
			'value'		=> $member->position,
			'maxlength'	=> '100',
			'size'		=> '50'
		);
$email = array(
			'id'			=> 'email',
			'name'			=> 'email',
			'value'			=> $member->email,
			'maxlength'		=> '100',
			'size'			=> '50',
			'placeholder'	=> 'http://'
		);

if($whattodo !== '')
{
	echo '<div class="main-box clearfix">';

	if($whattodo == 'chstatus')
	{
		if($chstatus)
			echo '<p class="notice">'.$lang['misc_done'].'</p>';
		else
			echo '<p class="notice red">'.$lang['error_common'].'</p>';
	}
	if($whattodo == 'edit')
	{
		if($edit_member)
			echo '<p class="notice">'.$lang['misc_done'].'</p>';
		else
			echo '<p class="notice red">'.$lang['error_common'].'</p>';
	}

	echo '</div>';
}

//begin with information form
echo form_open('admin_groups/edit_group_member/'.$groups_year_id.'/'.$member->user_id.'/edit'),'
<div class="main-box clearfix profile">
	<h2>'.$lang['admin_groups_editmember'].' <em>'.get_full_name($member).'</em>
	'.anchor('admin_user/user_list', '&larr; '.$lang['misc_back']).'</h2>';

	echo '<div class="row">';
		echo '<div class="col-2">',
			form_label($lang['admin_groups_position'], 'position'),
			form_input($position),
		'</div><!-- .col-2 -->';
		echo '<div class="col-2">',
			form_label('Email', 'email'),
			form_input($email),
		'</div><!-- .col-2 -->';
	echo '</div><!-- .row -->',
	'<div class="clearfix"></div>',
	form_submit('save', $lang['misc_save']);

echo '</div><!-- close .main-box -->',
form_close();

//drama area
?>
<div class="main-box clearfix">
	<h3>
		<?php echo $lang['admin_edituser_drama']; ?>
	</h3>
	<p>
		<?php
			echo anchor('admin_groups/edit_group_member/'.$groups_year_id.'/'.$member->user_id.'/delete', $lang['admin_groups_deletemember'], 'class="button"');
		?>
	</p>
</div>

