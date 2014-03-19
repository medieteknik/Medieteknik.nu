<?php
echo '
<div class="main-box box-body clearfix">
	<h2>',$lang['admin_addcarouselitem'],'</h2>
	<p>',anchor('admin/carousel/create/images', $lang['admin_addcarouselimageslidebyclicking']),'</p>
	<p>',anchor('admin/carousel/create/embedded', $lang['admin_addcarouselembeddedslidebyclicking']),'</p>
</div>';

$number_items = sizeof($carousel_array);

foreach($carousel_array as $item)
{
	//do_dump($item);
	$type = '';

	// Different types will behave differently.
	if($item->carousel_type == 1)
	{
		$type = 'Embedded content';
	}
	else if($item->carousel_type == 2)
	{
		$type = $lang['misc_images'];

	}

	echo '<div class="main-box box-body clearfix margin-top">';
		echo '<h4>'.$item->carousel_order.'. '.$type.'</h4>';
		echo '<p>';

			foreach($item->translations as $translation)
			{
				if(empty($translation->title))
				{
					echo $translation->language_name. ': '. $lang['admin_addtranslation'].'<br/>';
				}
				else
				{
					echo $translation->language_name. ': '. $translation->title. '<br/>';
				}
			}
			echo anchor('admin/carousel/edit/'.$item->id, 'edit').'<br/>';

			// Link to change order up or down. It's a bit shit. Maybe use jquery sortable or something.
			if($item->carousel_order != 1)
			{
				echo anchor('admin/carousel/moveup/'.$item->id, 'move up').'<br/>';
			}
			if($item->carousel_order != $number_items)
			{
				echo anchor('admin/carousel/movedown/'.$item->id, 'move down').'<br/>';
			}

		echo '</p>';
	echo '</div>';
}


