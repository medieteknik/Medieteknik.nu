<?php
if(!empty($message))
	echo '<div class="alert alert-success">'.$lang['misc_done'].'</div>';

echo '
<div class="main-box clearfix">
	<h3>',$lang['admin_addpage'],'</h3>
	<p>',anchor('admin/page/create', $lang['admin_createnewpagebyclicking']),'</p>
</div>';
?>
<div class="main-box clearfix margin-top">
	<h3>
		<?php
		echo $lang['admin_adminpage'];
		?>
	</h3>
	<ul class="list-unstyled box-list">
		<?php
		foreach($page_array as $page)
		{
			$draft = !$page->published ? ' <span class="label label-default">'.$lang['misc_draft'].'</span>' : '';
			echo '<li>';
			echo anchor('admin/page/edit/'.$page->id, $page->name.$draft, array('title' => $lang['page_editthepage']));
			echo '</li>';
		}
		?>
	</ul>
</div>
