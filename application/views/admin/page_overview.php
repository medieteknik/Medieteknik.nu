<?php
echo '
<div class="main-box clearfix">
	<h2>',$lang['admin_addpage'],'</h2>
	<p>',anchor('admin_page/create', $lang['admin_createnewpagebyclicking']),'</p>
</div>
<h2>',$lang['menu_archive'],'</h2>';



foreach($page_array as $page) {
	
	$classes = '';
	if($page->published == 1) {
		$classes = ' red';
	}
	
	$content = '<h2>'.$page->name.'</h2>';
	
	echo anchor('admin_page/edit/'.$page->id, $content, array("class" => "main-box news clearfix" . $classes, "title" => $lang['news_editthepage'] ));
}
			
