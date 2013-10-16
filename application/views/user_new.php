<?php
// prepare input form
$firstname = array(
			'id'		=> 'firstname',
			'name'		=> 'firstname',
			'value'		=> '',
			'maxlength'	=> '100',
			'size'		=> '50'
		);
$lastname = array(
	'id'		=> 'lastname',
	'name'		=> 'lastname',
	'value'		=> '',
	'maxlength'	=> '100',
	'size'		=> '50'
	);


if(isset($error))
{
	echo '<div class="main-box clearfix"><p class="notice red">'.$lang['error_common'].'</p></div>';
}


echo form_open('user/new_user/create'),
'<div class="main-box clearfix profile">
	<h2>Nytt konto: ', $user,'</h2>',
	'<div class="row">',
		'<div class="col-2">',
			form_label('Firstname', 'firstname'),
			form_input($firstname),
			form_label('Lastname', 'lastname'),
			form_input($lastname),
		'</div>',
	'</div>',
	'<div class="clearfix"></div>',
	form_submit('save', $lang['misc_save']);

echo '</div><!-- close .main-box -->',
form_close();
