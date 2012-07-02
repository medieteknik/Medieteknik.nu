<?php
$post_date = array(
              'name'        => 'post_date',
              'id'          => 'post_date',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
            );

$img_height = array(
              'name'        => 'img_height',
              'id'          => 'img_height',
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
            );
$options = array(
                  '1'  => '1/3',
                  '2'    => '1/2',
                  '3'   => '2/3',
                  '4'   => '1/1',
                );
$pos = array(
                  'left'  => $lang['misc_left'],
                  'right'    => $lang['misc_right'],
                );

$draft = array(
    'name'        => 'draft',
    'id'          => 'draft',
    'value'       => '1',
    'checked'     => FALSE,
    );
    
$approved = array(
    'name'        => 'approved',
    'id'          => 'approved',
    'value'       => '1',
    'checked'     => FALSE,
    );

echo form_open_multipart('admin_news/add_news');
echo '	<div class="main-box clearfix">
			<h2>'.$lang['admin_addnews'].'</h2>';
			echo form_label($lang['misc_postdate'], 'post_date');
			echo form_input($post_date);
			if($is_editor) {
				echo form_label($lang['misc_draft'], 'draft');
				echo form_checkbox($draft);
			}
			if($is_editor) {
				echo form_label($lang['misc_approved'], 'approved');
				echo form_checkbox($approved);
			}
			echo form_submit('save', $lang['misc_save']);
echo '	</div>';
echo '	<div class="main-box clearfix">
			<h2>'.$lang['misc_image'].'</h2>';
echo form_label($lang['misc_size'], 'img_size');
echo form_dropdown('img_size', $options);
echo form_label($lang['misc_position'], 'img_position');
echo form_dropdown('img_position', $pos);
echo form_label($lang['misc_height'], 'img_height');
echo '<input type="number" min="70" max="400" name="img_height" id="img_height" />';
//echo form_input($img_height);
echo '	</div>';


foreach($languages as $language) {
	$title = array(
              'name'        => 'title_'.$language['language_abbr'],
              'id'          => 'title_'.$language['language_abbr'],
              'value'       => '',
              'maxlength'   => '100',
              'size'        => '50',
            );
	$text = array(
              'name'        => 'text_'.$language['language_abbr'],
              'id'          => 'text_'.$language['language_abbr'],
            );
	
	echo '<div class="main-box clearfix">';
	echo '<h2>'.$language['language_name'].'</h2>';
	echo form_label($lang['misc_headline'], 'title_'.$language['language_abbr']);
	echo form_input($title);
	echo form_label($lang['misc_text'], 'text_'.$language['language_abbr']);
	echo form_textarea($text);
	echo '</div>';
}
echo form_close();
/*
echo '<h1>'.$lang['admin_addnews'].'</h1>';
echo '<div class="main-box clearfix">';
echo form_label($lang['misc_headline'], 'title');
echo form_input($title);
echo form_label($lang['misc_text'], 'text');
echo form_textarea($text);
echo '</div>';
echo form_close();
*/
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
