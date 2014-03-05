<?php

$lukasid = array(
              'id'          => 'lukasid',
              'name'        => 'lukasid',
              'maxlength'   => '100',
              'size'        => '50',
            );
$password = array(
              'id'          => 'password',
              'name'        => 'password',
              'maxlength'   => '100',
              'size'        => '50',
            );
$firstname = array(
              'id'          => 'firstname',
              'name'        => 'firstname',
              'maxlength'   => '100',
              'size'        => '50',
            );
$lastname = array(
              'id'          => 'lastname',
              'name'        => 'lastname',
              'maxlength'   => '100',
              'size'        => '50',
            );

echo
form_open_multipart('admin_user/user_add/create'),
'<div class="main-box clearfix"><h2>', $lang['admin_addusers'], '</h2>';

if(isset($status))
{
	if($status)
	{
		echo '<p class="notice">'.$lang['admin_addusers_success'].' '.anchor('admin/user/edit_user/'.$entered['lid'], $lang['admin_edituser']).'</p>';
	}
	else{
		echo $status;
		echo '<p class="notice red"><strong>'.$lang['admin_addusers_error'].'</strong> '.$errormsg;
		echo '</p>';

		$lastname['value'] = $entered['lname'];
		$lukasid['value'] = $entered['lid'];
		$password['value'] = $entered['pwd'];
		$firstname['value'] = $entered['fname'];
	}

}


echo form_label($lang['user_firstname'], 'firstname'),
	form_input($firstname),
	form_label($lang['user_lastname'], 'lastname'),
	form_input($lastname),
	form_label($lang['user_lukasid'], 'lukasid'),
	form_input($lukasid),
	form_label($lang['user_password'], 'password'),
	form_input($password),
	form_submit('save', $lang['misc_save']),
form_close(),
'</div><!-- close .main-box -->';
?>
