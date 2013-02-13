<?php
echo '
<div class="main-box clearfix">
	<h2>',$lang['admin_adminimages'],'</h2>
	<p>',anchor('admin_images/add_image', $lang['admin_addimagebyclickinghere']),'</p>
</div>
<h2>',$lang['menu_archive'],'</h2>		
<div class="main-box clearfix">';


//do_dump($image_array);
foreach($image_array as $img) {
	echo anchor('admin_images/delete/'.$img->id,$img->image->get_img_tag());
}
echo '</div>';	
