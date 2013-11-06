<?php
echo '
<div class="main-box clearfix">
	<h2>',$lang['admin_addgroup'],'</h2>
	<p>',anchor('admin_groups/create', $lang['admin_createnewgroupbyclicking']),'</p>
</div>

<h2>',$lang['admin_groups_official'],'</h2>';

foreach($groups_array as $group) {
	$classes = '';
	if($group->official == 1) {
		$content = '<h2>'.$group->name.'</h2>';
	
		echo anchor('admin_groups/edit/'.$group->id, $content, array("class" => "main-box news clearfix" . $classes, "title" => $lang['admin_editgroup'] ));
	}
}

echo '<h2>',$lang['admin_groups_unofficial'],'</h2>';
foreach($groups_array as $group) {
	$classes = '';
	if($group->official != 1) {
		$content = '<h2>'.$group->name.'</h2>';
	
		echo anchor('admin_groups/edit/'.$group->id, $content, array("class" => "main-box news clearfix" . $classes, "title" => $lang['admin_editgroup'] ));
	}
}
	
