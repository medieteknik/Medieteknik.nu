<?php
$post_date = array(
              'name'        => 'post_date',
              'id'          => 'post_date',
              'value'       => '',
              'placeholder' => $lang['date_placeholder'],
            );

$img_height = array(
              'name'        => 'img_height',
              'id'          => 'img_height',
              'value'       => '',
            );
$img_file = array(
              'name'        => 'img_file',
              'id'          => 'img_file',
              'value'       => '',
            );
$options = array(
                  '1'  => '1/3',
                  '2'    => '1/2',
                  '3'   => '2/3',
                  '4'   => '1/1',
                );
$pos = array(
                  '1'  => $lang['misc_left'],
                  '2'    => $lang['misc_right'],
                );

$draft = array(
    'name'        => 'draft',
    'id'          => 'draft',
    'value'       => '1',
    'checked'     => TRUE,
    );
    
$approved = array(
    'name'        => 'approved',
    'id'          => 'approved',
    'value'       => '1',
    'checked'     => FALSE,
    );

echo form_open_multipart('admin_news/add_news'),
'<div class="main-box clearfix">
	<h2>', $lang['admin_addnews'], '</h2>',
	form_label($lang['misc_postdate'], 'post_date'),
	form_input($post_date);
	if($is_editor) {
		echo '
		<div>',
			form_checkbox($draft),
			form_label($lang['misc_draft'], 'draft'),
		'</div>';
	}
	if($is_editor) {
		echo '
		<div>',
		form_checkbox($approved),
		form_label($lang['misc_approved'], 'approved'),
		'</div>';
	} else {
		echo form_hidden($lang['misc_approved'], 'approved');
	}
echo form_submit('save', $lang['misc_save']),
'</div>
<div class="main-box clearfix">
	<h2>'.$lang['misc_image'].'</h2>
	<div>',
		form_label($lang['misc_size'], 'img_size'),
		form_dropdown('img_size', $options),
	'</div>
	<div>',
		form_label($lang['misc_position'], 'img_position'),
		form_dropdown('img_position', $pos),
	'</div>
	<div>',
		form_label($lang['misc_height'], 'img_height'),
		'<input type="number" min="75" max="400" name="img_height" id="img_height" value="150" />
	</div>
	<div>',
		form_upload($img_file),
	'</div>
</div>';


foreach($languages as $language) {
	$title = array(
              'name'        => 'title_'.$language['language_abbr'],
              'id'          => 'title_'.$language['language_abbr'],
              'value'       => '',
            );
	$text = array(
              'name'        => 'text_'.$language['language_abbr'],
              'id'          => 'text_'.$language['language_abbr'],
            );
	
	echo '
	<div class="main-box clearfix">
		<h2>', $language['language_name'], '</h2>',
		form_label($lang['misc_headline'], 'title_'.$language['language_abbr']),
		form_input($title),
		form_label($lang['misc_text'], 'text_'.$language['language_abbr']),
		form_textarea($text),
	'</div>';
}
echo form_close();
