<?php
do_dump($group);

// prepare all the data
$official = array(		'name'        => 'official',
						'id'          => 'official',
						'value'       => '1',
						'checked'     => TRUE,
					);

// hack so that the same view can be used for both create and edit
//foreach($groups as $group)
//{
	$action = 'admin/groups/edit_group/0';
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
	//do_dump($t);

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

	//do_dump($name);

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

echo '<div class="main-box clearfix profile">';

if(isset($id))
{
	//Lista år
	$group_years = $this->Group_model->get_group_years($id);
	//do_dump($group_years);
	echo '<h2>'.$lang['admin_groups_editmembers'].'</h2>
		<ul class="box-list">';
			foreach($group_years as $group_year)
				echo '<li>'.anchor("admin/groups/list_members/".$group_year->id.'/'.$id, $group_year->start_year.'/'.$group_year->stop_year).'</li>';

		echo '</ul>
	<p>',anchor('admin/groups/add_year/'.$id, $lang['admin_createnewgroupbyclicking']),'</p>';
}

echo '</div><!-- close .main-box -->';

//Ta bort grupp
echo '
<div class="main-box news clearfix red">
<h2>',$lang['misc_delete'],'</h2>';
if(isset($id))
	echo form_open('admin/groups/delete/'.$id);
else
	echo form_open('admin/groups/delete');

echo form_submit('delete', 'Delete'),
form_close(),
'</div>
';
//}
