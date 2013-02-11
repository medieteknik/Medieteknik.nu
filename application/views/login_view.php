<?php
$username = array(
              'name'        => 'username',
              'id'          => 'username',
              'value'       => $attempt,
              'maxlength'   => '100',
              'size'        => '50',
            );
$password = array(
              'name'        => 'password',
              'id'          => 'password',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
            );



echo form_open('user/checklogin');
echo '<div class="main-box clearfix">';
echo '<h2>'.$lang['menu_login'].'</h2>';
if($attempt !== '')
  echo '<p class="notice red">'.$lang['user_login_fail'].'</p>';
echo form_label($lang['user_username'], 'username');
echo form_input($username);
echo form_label($lang['user_password'], 'password');
echo form_password($password);
echo form_submit('mysubmit', $lang['menu_login']);
echo '</div>';
echo form_close();
