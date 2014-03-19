<?php

// prepare all the data
$img_file = array(		'name'        => 'img_file',
						'id'          => 'img_file',
					);
$disabled = array(		'name'        => 'disabled',
						'id'          => 'disabled',
						'value'       => '1',
						'checked'     => FALSE,
					);
$draft = array(			'name'        => 'draft',
						'id'          => 'draft',
						'value'       => '1',
						'checked'     => FALSE,
					);
$photo = array(
		            	'name'        => 'photo',
		            	'id'          => 'photo',
		            	'size'		  =>	50,
     				 );
$link = array(
		            	'name'        => 'link',
		            	'id'          => 'link',
		            	'size'		  =>	50,
     				 );
$carousel_disabled = 0;
$carousel_draft = 0;

// hack so that the same view can be used for both create and edit
$action = 'admin/carousel/edit_carousel/0';
if(isset($carousel) && $carousel != false) {
	$disabled['checked'] = ($carousel->disabled == 1);
	$draft['checked'] = ($carousel->draft == 1);
	$carousel_disabled = $carousel->disabled;
	$carousel_draft = $carousel->draft;
	$action = 'admin/carousel/edit_carousel/'.$id;
}

$action_image = 'admin/carousel/add_image/0';
if(isset($carousel) && $carousel != false) {
	$action_image = 'admin/carousel/add_image/'.$id;
}

// do all the printing
echo
form_open($action, 'save'),
'<div class="main-box box-body clearfix">
	<h2>', $lang['admin_admincarousel'], '</h2>',
	form_checkbox($disabled),form_label($lang['misc_disabled'], 'disabled'),'<br />',
	form_checkbox($draft),form_label($lang['misc_draft'], 'draft'),'<br />',
	form_hidden('item_type', 2);
echo '<div>', form_submit('save', $lang['misc_save']), '</div>',
'</div>';

// hack so that the same view can be used for both create and edit
$arr = '';
if(isset($carousel) && $carousel != false) {
	$arr = $carousel->translations;
} else {
	$arr = $languages;
}

foreach($arr as $t) {

	// hack so that the same view can be used for both create and edit
	if(isset($carousel) && $carousel != false) {
		$t_title = $t->title;
		$t_content = $t->content;
		$language_abbr = $t->language_abbr;
		$language_name = $t->language_name;
	} else {
		$t_title = '';
		$t_content = '';
		$language_abbr = $t['language_abbr'];
		$language_name = $t['language_name'];
	}

	$title = array(
              'name'        => 'title_'.$language_abbr,
              'id'          => 'title_'.$language_abbr,
              'size'		=>	100,
              'value'       => $t_title,
            );
	$content = array(
              'name'        => 'content_'.$language_abbr,
              'id'          => 'content_'.$language_abbr,
              'rows'		=>	10,
              'cols'		=>	100,
            );

	echo '
	<div class="main-box box-body clearfix">
	<h2>',$language_name,'</h2>',
	form_label($lang['misc_headline'], 'title_'.$language_abbr),'<br />',
	form_input($title),'<br />',
	form_label($lang['misc_text'], 'content_'.$language_abbr),'<br />',
	form_textarea($content,$t_content),'<br />',
	'</div>';
}
echo form_close();

// Carousel must exist before you can add images
if(isset($carousel) && $carousel != false) {
	// Images
	echo '<div class="main-box box-body clearfix">
		<h2>'.$lang['misc_images'].'</h2>';
		// Show images
		if(isset($carousel) && $carousel != false)
			if (count($images_array) > 0) {
				foreach($images_array as $img) {
					if($img->image_original_filename != "") {
						$image = new imagemanip($img->image_original_filename, 'zoom', 100, 100);
						echo '<img src="'.$image.'"/>';
						echo anchor('admin/carousel/remove_image/'.$id.'/'.$img->images_id, $lang['admin_removeimage']);
					}
				}
			}

		// Open form to upload new image
		echo form_open_multipart($action_image, 'add_image');

		echo '<h3>'.$lang['admin_addimage'].'</h3>';
		echo '<div>',
			form_label($lang['misc_photo'], 'photo'),
			form_input($photo),
			form_label($lang['misc_link'], 'link'),
			form_input($link),
		'</div>
		<div>',
			form_upload($img_file),
		'</div>';
		echo form_submit('add_image', $lang['misc_upload']);
		echo form_close();
	echo '</div>';
}

if(isset($carousel) && $carousel != false) {
	echo '
	<div class="main-box box-body news clearfix red">
	<h2>Delete</h2>',
	form_open('admin/carousel/delete/'.$id),
	form_submit('delete', 'Delete'),
	form_close(),
	'</div>
	';
}
