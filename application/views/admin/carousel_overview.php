<?php
echo '
<div class="row">
	<div class="col-sm-12">
		<div class="main-box box-body clearfix">
			<h4>',$lang['admin_addcarouselitem'],'</h4>
			<p>',anchor('admin/carousel/create/images', $lang['admin_addcarouselimageslidebyclicking']),'</p>
			<p>',anchor('admin/carousel/create/embedded', $lang['admin_addcarouselembeddedslidebyclicking']),'</p>
		</div>
	</div>
</div>';
$number_items = sizeof($carousel_array);

// foreach($carousel_array as $item)
// {
// 	//do_dump($item);
// 	$type = '';

// 	// Different types will behave differently.
// 	if($item->carousel_type == 1)
// 	{
// 		$type = $lang['misc_embeddedcontent'];
// 	}
// 	else if($item->carousel_type == 2)
// 	{
// 		$type = $lang['misc_images'];

// 	}

// 	echo '<div class="main-box box-body clearfix margin-top">';
// 		echo '<h4>'.$item->carousel_order.'. '.$type.'</h4>';
// 		echo '<p>';

// 			foreach($item->translations as $translation)
// 			{
// 				if(empty($translation->title))
// 				{
// 					echo $translation->language_name. ': '. $lang['admin_addtranslation'].'<br/>';
// 				}
// 				else
// 				{
// 					echo $translation->language_name. ': '. $translation->title. '<br/>';
// 				}
// 			}
// 			echo anchor('admin/carousel/edit/'.$item->id, 'edit').'<br/>';

// 			// Link to change order up or down. It's a bit shit. Maybe use jquery sortable or something.
// 			if($item->carousel_order != 1)
// 			{
// 				echo anchor('admin/carousel/moveup/'.$item->id, 'move up').'<br/>';
// 			}
// 			if($item->carousel_order != $number_items)
// 			{
// 				echo anchor('admin/carousel/movedown/'.$item->id, 'move down').'<br/>';
// 			}

// 		echo '</p>';
// 	echo '</div>';
// }


foreach($carousel_array as $item) {
	
	$type = '';

	// Different types will behave differently.
	if($item->carousel_type == 1)
	{
		$type = $lang['misc_embeddedcontent'];
	}
	else if($item->carousel_type == 2)
	{
		$type = $lang['misc_images'];

	}

	?>
	<div class="main-box box-body clearfix admin-news-entry margin-top">
		<div class="row">
			<div class="col-sm-12">
				<h4><?php
						echo $type.' - ';
						echo anchor('admin/carousel/edit/'.$item->id, $lang['misc_edit']);
					if($item->disabled)
						echo ' <span class="label label-danger">'.$lang['misc_disabled'].'</span>';
					if($item->draft)
						echo ' <span class="label label-default">'.$lang['misc_draft'].'</span>';
					?>
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<h4><?php echo $lang['admin_carousel_changeorder']?></h4>
				<p>
					<?php
						if($item->carousel_order != 1)
						{
							echo anchor('admin/carousel/moveup/'.$item->id, '<span class="glyphicon glyphicon-chevron-up"></span>', array('class' => 'btn btn-warning'));
						}
					?>
				</p>
				<p>
					<?php
						if($item->carousel_order != $number_items)
						{
							echo anchor('admin/carousel/movedown/'.$item->id, '<span class="glyphicon glyphicon-chevron-down"></span>', array('class' => 'btn btn-warning'));
						}
					?>
				</p>
			</div>
			<?php
				foreach ($item->translations as $translation) {
					?>
					<div class="col-sm-4">
						<h4>
							<?php echo $translation->language_name;?>
							<img src="<?php echo lang_id_to_imgpath($translation->lang_id); ?>" class="img-circle">
						</h4>
						<p>
							<?php echo $translation->title; ?>
						</p>
					</div>
					<?php
				}
				?>
		</div>
	</div>
	<?php
}
