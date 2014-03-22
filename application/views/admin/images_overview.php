	<?php
echo '
<div class="row">
<div class="col-sm-12">
<div class="main-box box-body clearfix">
	<h3>',$lang['admin_news_uploadimage'],'</h3>
	<p>',anchor('admin/images/add_image', $lang['admin_addimagebyclickinghere']),'</p>
</div>
</div>
<div class="col-sm-12">
<div class="main-box box-body clearfix margin-top">
<h3>',$lang['menu_archive'],'</h3>';



//do_dump($image_array);
foreach($image_array as $img) {
	echo
	'<div class="col-xs-2">',
		$img->image->get_img_tag('class="thumbnail centered"'),'<br />',
		'<b>',$img->image_title,'</b><br />',
		anchor('admin/images/delete/'.$img->id,"Delete"),
	'</div>';
}
echo '</div>
</div>
</div>';
