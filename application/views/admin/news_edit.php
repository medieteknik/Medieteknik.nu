<?php


// do_dump($news);

$post_date = array(
              'name'        => 'post_date',
              'id'          => 'post_date',
              'value'       => $news->date,
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
$image_div = "";
if($news->image_original_filename != "") {
	$image = new imagemanip($news->image_original_filename, 'zoom', news_size_to_px($news->size), $news->height);
	$image_div = '<div><img src="'.$image.'"/></div>';
}


$draft_checked = FALSE;
if($news->draft == 1) $draft_checked = TRUE;

$draft = array(
    'name'        => 'draft',
    'id'          => 'draft',
    'value'       => '1',
    'checked'     => $draft_checked,
    );

$approved_checked = FALSE;
if($news->approved == 1) $approved_checked = TRUE;
$approved = array(
    'name'        => 'approved',
    'id'          => 'approved',
    'value'       => '1',
    'checked'     => $approved_checked,
    );

echo 
form_open_multipart('admin_news/edit_news/'.$id),
'<div class="main-box clearfix">
	<h2>', $lang['admin_editnews'], '</h2>',
	form_label($lang['misc_postdate'], 'post_date'),
	form_input($post_date);
	if($is_editor) {
		echo '<div>', form_checkbox($draft),form_label($lang['misc_draft'], 'draft'),'</div>';
	}
	if($is_editor) {
		echo '<div>', form_checkbox($approved),form_label($lang['misc_approved'], 'approved'), '</div>';
	} else {
		echo form_hidden($lang['misc_approved'], array('name' => 'approved','id' => 'approved', 'value' => $news->approved));
	}
echo form_submit('save', $lang['misc_save']),
'</div>
<div class="main-box clearfix">
	<h2>'.$lang['misc_image'].'</h2>',
	$image_div,
	'<div>',
		form_label($lang['misc_size'], 'img_size'),
		form_dropdown('img_size', $options, $news->size),
	'</div>
	<div>',
		form_label($lang['misc_position'], 'img_position'),
		form_dropdown('img_position', $pos, $news->position),
	'</div>
	<div>',
		form_label($lang['misc_height'], 'img_height'),
		'<input type="number" min="75" max="400" name="img_height" id="img_height" value="'.$news->height.'" />',
	'</div>
	<div>',
		form_upload($img_file),
	'</div>
</div>';


foreach($news->translations as $t) {
	
	$title = array(
              'name'        => 'title_'.$t->language_abbr,
              'id'          => 'title_'.$t->language_abbr,
              'value'       => $t->title,
            );
	$text = array(
              'name'        => 'text_'.$t->language_abbr,
              'id'          => 'text_'.$t->language_abbr,
              'value'       => $t->text,
            );
	
	echo '
	<div class="main-box clearfix">
	<h2>',$t->language_name,'</h2>',
	form_label($lang['misc_headline'], 'title_'.$t->language_abbr),
	form_input($title),
	form_label($lang['misc_text'], 'text_'.$t->language_abbr),
	form_textarea($text),
	'</div>';
}
echo form_close();
