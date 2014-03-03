<?php

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
$gravatar = array(
			'id'			=> 'gravatar',
			'name'			=> 'gravatar',
			'value'			=> $user->gravatar,
			'maxlength'		=> '254',
			'size'			=> '40',
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


if(isset($run))
{
	if($status)
		echo '<div class="alert alert-success">'.$lang['misc_done'].'</div>';
	else
		echo '<div class="alert alert-danger">'.$lang['error_common'].'</div>';
}


echo form_open('user/edit_profile/runedit'),
'<div class="main-box clearfix profile">
	<h2>Redigera konto</h2>',
	'<div class="row">',
		'<div class="col-2">',
			form_label('Twitter', 'twitter'),
			form_input($twitter),
			form_label('LinkedIn', 'linkedin'),
			form_input($linkedin),
			form_label('Web', 'web'),
			form_input($web),
		'</div>',
		'<div class="col-2">',
			'<p>',
			gravatarimg($user, 80, ' style="float:right;"'),
			form_label('Gravatar-adress', 'gravatar'),
			form_input($gravatar),
			'</p><p>',$lang['user_gravatar'],'</p>',
		'</div>',
	'</div>',
	form_label('Presentation', 'presentation'),
	'<div class="clearfix"></div>',
	form_textarea($presentation),
	'<div class="clearfix"></div>',
	form_submit('save', $lang['misc_save']);

echo '</div><!-- close .main-box -->',
form_close();
