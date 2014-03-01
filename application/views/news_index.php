<?php
$i = 0;
echo '<div class="row">';
foreach($news_array as $news_item)
{
	// do_dump($news_item);
	$img_div = "";
	$news_class = "main-box";
	$style = "";
	if($news_item->image_original_filename != "")
	{
		$image = new imagemanip();
		$image->create($news_item->image_original_filename, 'zoom', news_size_to_px($news_item->size), $news_item->height);

		$img_div = '<img class="'.news_size_to_class($news_item->size).'" src="'.$image->get_filepath().'" alt="'.$news_item->title.'" />';
		$news_class = news_size_to_class_invert($news_item->size);
		$style = 'max-height:'.$news_item->height.'px; overflow: hidden;';
	}

	$lang_img = '<img src="'.lang_id_to_imgpath($news_item->lang_id).'" alt="flag" class="news_flag" />';
	$news_div = '<div style="'.$style.'" class="'.$news_class.'">'.$lang_img.'<h2>'.$news_item->title.'</h2><p>'.text_format($news_item->text, '<p>','</p>', FALSE).'</p></div>';

	$story = "";
	if($news_item->position == 1 || $news_item->size == 4)
	{
		$story = $img_div.$news_div;
	} else {
		$story = $news_div.$img_div;
	}
	// echo anchor('news/view/'.$news_item->id, $story, array("class" => "main-box news clearfix", "title" => $lang['news_tothenews'] ));

	// every third news is displayed large
	if($i%3 == 0)
	{
		$news_story = news_excerpt(text_format($news_item->text, '<p>','</p>', FALSE), 500);
		?>
			<div class="col-sm-12">
				<div class="main-box news clearfix">
					<h2>
						<?php echo anchor('news/view/'.$news_item->id, $news_item->title, array("title" => $lang['news_tothenews'])); ?>
						<?php
						if($news_item->draft)
							echo '<span class="label label-default">'.$lang['misc_draft'].'</span>';
						?>
						<img src="<?php echo lang_id_to_imgpath($news_item->lang_id); ?>" class="img-circle pull-right" />
					</h2>
					<h3>
						Publicerad
						<i class="date" title="<?php echo $news_item->date; ?>">
							<?php echo readable_date($news_item->date, $lang); ?>
						</i>
						av <?php echo anchor('user/profile/'.$news_item->userid, $news_item->first_name.' '.$news_item->last_name); ?>
					</h3>
					<p>
						<?php echo $news_story; ?>... <?php echo anchor('news/view/'.$news_item->id, $lang['misc_readmore'].'!');?>
					</p>
				</div>
			</div>
		</div> <!-- /.row -->
		<div class="row">
		<?php
	}
	else
	{
		$news_story = news_excerpt(text_format($news_item->text, '<p>','</p>', FALSE), 200);
		?>
		<div class="col-sm-6">
			<div class="main-box news clearfix">
				<h2>
					<img src="<?php echo lang_id_to_imgpath($news_item->lang_id); ?>" class="img-circle pull-right" />
					<?php echo anchor('news/view/'.$news_item->id, $news_item->title, array("title" => $lang['news_tothenews'])); ?>
					<?php
					if($news_item->draft)
						echo '<span class="label label-default">'.$lang['misc_draft'].'</span>';
					?>
				</h2>
				<h3>
					Publicerad
					<i class="date" title="<?php echo $news_item->date; ?>">
						<?php echo readable_date($news_item->date, $lang); ?>
					</i>
					av <?php echo anchor('user/profile/'.$news_item->userid, $news_item->first_name.' '.$news_item->last_name); ?>
				</h3>
				<p>
					<?php echo $news_story; ?>... <?php echo anchor('news/view/'.$news_item->id, $lang['misc_readmore'].'!');?>
				</p>
			</div>
		</div>
		<?php

	}
	// increment counter
	$i++;
}
echo '</div><!-- /.row -->';
//do_dump($news_array);
