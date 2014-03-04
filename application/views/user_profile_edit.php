<?php

$twitter = array(
			'id'		=> 'twitter',
			'name'		=> 'twitter',
			'value'		=> $user->twitter,
			'maxlength'	=> '100',
			'class' 	=> 'form-control'
		);
$linkedin = array(
			'id'			=> 'linkedin',
			'name'			=> 'linkedin',
			'value'			=> $user->linkedin,
			'maxlength'		=> '100',
			'placeholder'	=> 'http://linkedin.com/in/...',
			'class' 	=> 'form-control'
		);
$gravatar = array(
			'id'			=> 'gravatar',
			'name'			=> 'gravatar',
			'value'			=> $user->gravatar,
			'maxlength'		=> '254',
			'placeholder'	=> 'mt@example.com',
			'class' 		=> 'form-control'
		);
$web = array(
			'id'			=> 'web',
			'name'			=> 'web',
			'value'			=> $user->web,
			'maxlength'		=> '100',
			'placeholder'	=> 'http://...',
			'class' 	=> 'form-control'
		);
$presentation = array(
			'id'		=> 'presentation',
			'name'		=> 'presentation',
			'value'		=> $user->presentation,
			'rows'		=> '4',
			'placeholder' => $lang['misc_text'],
			'class' 	=> 'form-control'
		);


if(isset($status) && strlen($status) > 0)
{
	if ($status == 'success')
		echo '<div class="alert alert-success">'.$lang['misc_done'].'</div>';
	else if ($status == 'fail')
		echo '<div class="alert alert-danger">'.$lang['error_common'].'</div>';
}


echo form_open('user/edit_profile/runedit'),
'<div class="main-box clearfix profile">
	<h3>',
		$lang['profile_edit'],
		' <small>',get_full_name($user),' ',anchor('user', $lang['profile_back']),'</small>',
	'</h3>',
	'<div class="row">',
		'<div class="col-sm-5">',
			'<p>',
				form_label('Twitter', 'twitter'),
				form_input($twitter),
			'</p><p>',
				form_label('LinkedIn', 'linkedin'),
				form_input($linkedin),
			'</p><p>',
				form_label('Web', 'web'),
				form_input($web),
			'</p>',
		'</div>',
		'<div class="col-sm-3 col-sm-push-4">',
			gravatarimg($user, 300, ' class="img-responsive img-circle"'),
		'</div>',
		'<div class="col-sm-4 col-sm-pull-3">',
			'<p>',
			form_label('Gravatar-adress', 'gravatar'),
			form_input($gravatar),
			'</p><p>',$lang['user_gravatar'],'</p>',
		'</div>',
	'</div>',
	'<div class="row">',
		'<div class="col-sm-9"><p>',
			form_label('Presentation', 'presentation'),
			form_textarea($presentation),
		'</p></div>',
		'<div class="col-sm-3"><p>',
			form_label('&nbsp;', 'save'),
			'<input type="submit" id="save" name="save" value="',$lang['misc_save'],'" class="form-control btn btn-success" />',
		'</p></div>',
	'</div>',
'</div><!-- close .main-box -->',
form_close();
