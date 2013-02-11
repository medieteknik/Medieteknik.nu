<?php

if($user->id == 0)
	redirect('error_page/user/?msg=notfound-adm', 'refresh');

$lukasid = array(
			'id'		=> 'lukasid',
			'name'		=> 'lukasid',
			'value'		=> $user->lukasid,
			'maxlength'	=> '100',
			'size'		=> '50'
		);
$firstname = array(
			'id'		=> 'firstname',
			'name'		=> 'firstname',
			'value'		=> $user->first_name,
			'maxlength'	=> '100',
			'size'		=> '50'
		);
$lastname = array(
			'id'		=> 'lastname',
			'name'		=> 'lastname',
			'value'		=> $user->last_name,
			'maxlength'	=> '100',
			'size'		=> '50'
		);
$password = array(
			'id'			=> 'password',
			'name'			=> 'password',
			'maxlength'		=> '100',
			'size'			=> '50'
		);
$twitter = array(
			'id'		=> 'twitter',
			'name'		=> 'twitter',
			'value'		=> $user->twitter,
			'maxlength'	=> '100',
			'size'		=> '50'
		);
$linkedin = array(
			'id'			=> 'linkedin',
			'name'			=> 'linkedin',
			'value'			=> $user->linkedin,
			'maxlength'		=> '100',
			'size'			=> '50',
			'placeholder'	=> 'http://linkedin.com/in/...'
		);
$web = array(
			'id'			=> 'web',
			'name'			=> 'web',
			'value'			=> $user->web,
			'maxlength'		=> '100',
			'size'			=> '50',
			'placeholder'	=> 'http://'
		);
$presentation = array(
			'id'		=> 'presentation',
			'name'		=> 'presentation',
			'value'		=> $user->presentation,
			'rows'		=> '4',
			'cols'		=> '70'
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
		if($edit_data && $edit_user)
			echo '<p class="notice">'.$lang['misc_done'].'</p>';
		else
			echo '<p class="notice red">'.$lang['error_common'].'</p>';
	}


	echo '</div>';
}



//begin with information form
echo form_open('admin_user/edit_user/'.$user->id.'/edit'),'
<div class="main-box clearfix profile">
	<h2>'.$lang['admin_edituser'].' <em>'.get_full_name($user).'</em>
	'.anchor('admin_user/user_list', '&larr; '.$lang['misc_back']).'</h2>';

	echo '<div class="row">';
		echo '<div class="col-2">',
			form_label($lang['user_firstname'], 'firstname'),
			form_input($firstname),
			form_label($lang['user_lastname'], 'lastname'),
			form_input($lastname),
			form_label($lang['user_lukasid'], 'lukasid'),
			form_input($lukasid),
		'</div><!-- .col-2 -->';
		echo '<div class="col-2">',
			form_label('Twitter', 'twitter'),
			form_input($twitter),
			form_label('LinkedIn', 'linkedin'),
			form_input($linkedin),
			form_label('Web', 'web'),
			form_input($web),
		'</div><!-- .col-2 -->';
	echo '</div><!-- .row -->',

	form_label('Presentation', 'presentation'),
	'<div class="clearfix"></div>',
	form_textarea($presentation),
	'<div class="clearfix"></div>',
	form_submit('save', $lang['misc_save']);

echo '</div><!-- close .main-box -->',
form_close();

//drama area
?>
<div class="main-box clearfix">
	<div class="row">
		<div class="col-2">
			<h3>
				<?php echo $lang['admin_edituser_drama']; ?>
			</h3>
			<p>
				<?php
					$text = ($user->disabled ? $lang['admin_edituser_activate'] : $lang['admin_edituser_deactivate']);
					echo anchor('admin_user/edit_user/'.$user->id.'/chstatus', $text, 'class="button"');
				?>
			</p>
		</div><!-- .col-2 -->
		<div class="col-2">
			<h3>
				<?php echo $lang['admin_edituser_delete']; ?>
			</h3>
			<p>
				Kanske inte användbart? Kanske inte ska gå?
			</p>
		</div><!-- .col-2 -->
	</div>
</div><!-- .row -->

