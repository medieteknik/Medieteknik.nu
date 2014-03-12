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

$carousel_disabled = 0;
$carousel_url = '';

// hack so that the same view can be used for both create and edit
$action = 'admin/carousel/edit_carousel/0';
if(isset($carousel) && $carousel != false) {
	$disabled['checked'] = ($carousel->disabled == 1);
	$carousel_disabled = $carousel->disabled;
	$carousel_url = $carousel->translations[0]->content;
	$action = 'admin/carousel/edit_carousel/'.$id;
}

$url = array(
		            	'name'        => 'content_',
		            	'id'          => 'content_',
		            	'value' 	  => $carousel_url,
		            	'size'		  => 50,
     				 );

// do all the printing
echo
form_open($action, 'save'),
'<div class="main-box clearfix">
	<h2>', $lang['admin_admincarousel'], '</h2>',
	'<div>', form_checkbox($disabled),form_label($lang['misc_disabled'], 'disabled'),'</div>',
	form_hidden('item_type', 1),
	form_label('URL', 'content'),
	form_input($url),
'<div>', form_submit('save', $lang['misc_save']), '</div>',
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
              'size'		=>	50,
              'value'       => $t_title,
            );

	echo '
	<div class="main-box clearfix">
	<h2>',$language_name,'</h2>',
	form_label($lang['misc_headline'], 'title_'.$language_abbr),
	form_input($title),
	'</div>';
}
echo form_close();

if(isset($carousel) && $carousel != false) {
	echo '
	<div class="main-box news clearfix red">
	<h2>Delete</h2>',
	form_open('admin/carousel/delete/'.$id),
	form_submit('delete', 'Delete'),
	form_close(),
	'</div>
	';
}
