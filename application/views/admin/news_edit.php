<?php

// prepare all the data
$post_date = array(		'name'        => 'post_date',
						'id'          => 'post_date',
						'value'       => '',
						'placeholder' => $lang['date_placeholder'],
					);

$img_height = array(	'name'        => 'img_height',
						'id'          => 'img_height',
						'value'       => '',
					);
$img_file = array(		'name'        => 'img_file',
						'id'          => 'img_file',
					);
$options = 	array(		'1'  => '1/3',
						'2'    => '1/2',
						'3'   => '2/3',
						'4'   => '1/1',
					);
$pos = array(			'1'  => $lang['misc_left'],
						'2'    => $lang['misc_right'],
					);
$draft = array(			'name'        => 'draft',
						'id'          => 'draft',
						'value'       => '1',
						'checked'     => TRUE,
					);
$approved = array(		'name'        => 'approved',
						'id'          => 'approved',
						'value'       => '1',
						'checked'     => FALSE,
					);
$news_approved = 0;
$news_size = 0;
$news_position = 0;
$news_height = 100;

// hack so that the same view can be used for both create and edit
$image_div = "";
$action = 'admin_news/add_news';
if(isset($news) && $news != false) {
	$post_date['value'] = $news->date;
	$draft['checked'] = ($news->draft == 1);
	$approved['checked'] = ($news->approved == 1);
	$news_approved = $news->approved;
	$news_size = $news->size;
	$news_height = ($news->height == '') ? $news_height : $news->height;
	$action = 'admin_news/edit_news/'.$id;
	
	if($news->image_original_filename != "") {
		$image = new imagemanip($news->image_original_filename, 'zoom', news_size_to_px($news->size), $news->height);
		$image_div = '<div><img src="'.$image.'"/></div>';
	}
}



// do all the printing
echo 
form_open_multipart($action),
'<div class="main-box clearfix">
	<h2>', $lang['admin_editnews'], '</h2>',
	form_label($lang['misc_postdate'], 'post_date'),
	form_input($post_date),
	'<div>', form_checkbox($draft),form_label($lang['misc_draft'], 'draft'),'</div>';
	
	if($is_editor) {
		echo '<div>', form_checkbox($approved),form_label($lang['misc_approved'], 'approved'), '</div>';
	} else {
		echo form_hidden($lang['misc_approved'], array('name' => 'approved','id' => 'approved', 'value' => $news_approved));
	}
echo '<div>', form_submit('save', $lang['misc_save']), '</div>',
'</div>
<div class="main-box clearfix">
	<h2>'.$lang['misc_image'].'</h2>',
	$image_div,
	'<div>',
		form_label($lang['misc_size'], 'img_size'),
		form_dropdown('img_size', $options, $news_size, 'id="img_size"'),
	'</div>
	<div>',
		form_label($lang['misc_position'], 'img_position'),
		form_dropdown('img_position', $pos, $news_position, 'id="img_position"'),
	'</div>
	<div>',
		form_label($lang['misc_height'], 'img_height'),
		'<input type="number" min="75" max="400" name="img_height" id="img_height" value="'.$news_height .'" />',
	'</div>
	<div>',
		form_upload($img_file),
	'</div>
</div>';

// hack so that the same view can be used for both create and edit
$arr = '';
if(isset($news) && $news != false) { 
	$arr = $news->translations;
} else {
	$arr = $languages;
}

//do_dump($arr);
foreach($arr as $t) {
	
	$t_title = '';
	$t_text = '';
	$language_abbr = '';
	$language_name = '';

	// hack so that the same view can be used for both create and edit
	if(isset($news) && $news != false) { 
		$t_title = $t->title;
		$t_text = $t->text;
		$language_abbr = $t->language_abbr;
		$language_name = $t->language_name;
	} else {
		$t_title = '';
		$t_text = '';
		$language_abbr = $t['language_abbr'];
		$language_name = $t['language_name'];
	}

	$title = array(
              'name'        => 'title_'.$language_abbr,
              'id'          => 'title_'.$language_abbr,
              'value'       => $t_title,
            );
	$text = array(
              'name'        => 'text_'.$language_abbr,
              'id'          => 'text_'.$language_abbr,
              'rows'		=>	10,
              'cols'		=>	85,
            );
	
	echo '
	<div class="main-box clearfix">
	<h2>',$language_name,'</h2>',
	form_label($lang['misc_headline'], 'title_'.$language_abbr),
	form_input($title),
	form_label($lang['misc_text'], 'text_'.$language_abbr),
	form_textarea($text,$t_text),
	'</div>';
}
echo form_close();

echo '
<div class="main-box news clearfix red">
<h2>Delete</h2>',
form_open('admin_news/delete'),
form_submit('delete', 'Delete'),
form_close(),
'</div>
';
