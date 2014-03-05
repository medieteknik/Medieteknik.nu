<?php
echo '
<div class="main-box clearfix">
	<h2>',$lang['admin_adminimages'],'</h2>
	<p>',anchor('admin/images/add_image', $lang['admin_addimagebyclickinghere']),'</p>
</div>
<h2>',$lang['menu_archive'],'</h2>
<div class="main-box clearfix">';


//do_dump($image_array);
foreach($image_array as $img) {
	echo
	'<div class="image_overview" style="display: inline-block; width: 150px; height: 150px; overflow:hidden; clear:both;">',
		$img->image->get_img_tag(),'<br />',
		'<b>',$img->image_title,'</b><br />',
		anchor('admin_images/delete/'.$img->id,"Delete"),
	'</div>';
}
echo '</div>';
