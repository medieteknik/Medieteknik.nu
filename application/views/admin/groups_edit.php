<?php

// prepare all the data
$official = array(		'name'        => 'official',
						'id'          => 'official',
						'value'       => '1',
						'checked'     => TRUE,
					);

// hack so that the same view can be used for both create and edit
//foreach($groups as $group)
//{
	$action = 'admin_groups/edit_group/0';
	if(isset($group) && $group != false) {
		$official['checked'] = ($group->official == 1);
		$action = 'admin_groups/edit_group/'.$id;
	}


// do all the printing
echo 
form_open($action),
'<div class="main-box clearfix">
	<h2>', $lang['admin_editgroup'], '</h2>',
	'<div>', form_checkbox($official),form_label($lang['misc_official'], 'official'),'</div>',
	'<div>', form_submit('save', $lang['misc_save']), '</div>',
'</div>';

// hack so that the same view can be used for both create and edit
//do_dump($page);
$arr = '';
if(isset($group) && $group != false) { 
	$arr = $group->translations;
} else {
	$arr = $languages;
}

foreach($arr as $t) {
	$t_name = '';
	$t_description = '';
	$language_abbr = '';
	$language_name = '';

	// hack so that the same view can be used for both create and edit
	if(isset($group) && $group != false) { 
		$t_name = $t->name;
		$t_description = $t->description;
		$language_abbr = $t->language_abbr;
		$language_name = $t->language_name;
	} else {
		$t_name = '';
		$t_description = '';
		$language_abbr = $t['language_abbr'];
		$language_name = $t['language_name'];
	}

	$name = array(
              'name'        => 'name_'.$language_abbr,
              'id'          => 'name_'.$language_abbr,
              'value'       => $t_name,
            );
	$description = array(
              'name'        => 'description_'.$language_abbr,
              'id'          => 'description_'.$language_abbr,
              'rows'		=>	10,
              'cols'		=>	85,
            );
	
	echo '
	<div class="main-box clearfix">
	<h2>',$language_name,'</h2>',
	form_label($lang['misc_headline'], 'title_'.$language_abbr),
	form_input($name),
	form_label($lang['misc_text'], 'text_'.$language_abbr),
	form_textarea($description,$t_description),
	'</div>';
}
echo form_close();

echo '
<div class="main-box news clearfix red">
<h2>Delete</h2>';
if(isset($id))
	echo form_open('admin_groups/delete/'.$id);
else
	echo form_open('admin_groups/delete');

echo form_submit('delete', 'Delete'),
form_close(),
'</div>
';
//}
