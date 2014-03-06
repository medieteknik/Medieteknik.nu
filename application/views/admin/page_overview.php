<?php
if(!empty($message))
	echo '<div class="alert alert-success">'.$lang['misc_done'].'</div>';

echo '
<div class="main-box clearfix">
	<h3>',$lang['admin_addpage'],'</h3>
	<p>',anchor('admin/page/create', $lang['admin_createnewpagebyclicking']),'</p>
</div>';

foreach($page_array as $page) {
	?>
	<div class="main-box clearfix margin-top">
		<h3>
			<?php
			echo anchor('admin/page/edit/'.$page->id, $page->name, array('title' => $lang['page_editthepage']));
			echo !$page->published ? ' <span class="label label-default">'.$lang['misc_draft'].'</span>' : '';
			?>
		</h3>
	</div>
	<?php
}

// do_dump($page_array);
