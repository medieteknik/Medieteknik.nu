<?php

$title = array(
              'name'        => 'title',
              'id'          => 'title',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
            );
$text = array(
              'name'        => 'text',
              'id'          => 'text',
            );

echo form_open_multipart('admin/add_news');
echo '<h1>'.$lang['admin_addnews'].'</h1>';
echo '<div class="main-box clearfix">';
echo form_label($lang['misc_headline'], 'title');
echo form_input($title);
echo form_label($lang['misc_text'], 'text');
echo form_textarea($text);
echo '</div>';
echo form_close();

/*
echo form_open('admin/add_news');

echo '<div class="main-box clearfix">';
echo '<h2>'.$lang['admin_addnews'].'</h2>';
echo '<p></p>';
echo '</div>';

echo '<div class="main-box clearfix">';
echo form_label($lang['misc_headline'], 'title');
echo form_input($username);
echo form_label($lang['misc_text'], 'password');
//echo form_textarea($text);
echo form_submit('mysubmit', $lang['menu_login']);
echo '</div>';

echo form_close();


*/
