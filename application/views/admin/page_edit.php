<?php

// prepare all the data
$draft = array(			'name'        => 'draft',
						'id'          => 'draft',
						'value'       => '1',
						'checked'     => TRUE,
					);
$pagename = array(			'name'        => 'pagename',
						'id'          => 'pagename',
					);

// hack so that the same view can be used for both create and edit
$action = 'admin_page/edit_page/0';
if(isset($page) && $page != false) {
	$draft['checked'] = ($page->published == 1);
	$action = 'admin_page/edit_page/'.$id;
	$pagename['value'] = $page->name;
}

// do all the printing
echo 
form_open($action),
'<div class="main-box clearfix">
	<h2>', $lang['admin_editpage'], '</h2>',
	'<div>', form_checkbox($draft),form_label($lang['misc_draft'], 'draft'),'</div>',
	form_input($pagename),
	'<div>', form_submit('save', $lang['misc_save']), '</div>',
'</div>';

// hack so that the same view can be used for both create and edit

//do_dump($page);
$arr = '';
if(isset($page) && $page != false) { 
	$arr = $page->translations;
} else {
	$arr = $languages;
}

//do_dump($page);
do_dump($arr);
foreach($arr as $t) {

	$t_title = '';
	$t_text = '';
	$language_abbr = '';
	$language_name = '';

	// hack so that the same view can be used for both create and edit
	if(isset($page) && $page != false) { 
		$t_title = $t->header;
		$t_text = $t->content;
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
form_open('admin_page/delete'),
form_submit('delete', 'Delete'),
form_close(),
'</div>
';
