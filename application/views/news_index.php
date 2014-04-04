<?php
$i = 0;
echo '<div class="row">';
foreach($news_array as $news_item)
{
	$news_story = news_excerpt(text_format($news_item->text, '<p>','</p>', FALSE), 400);
	?>
		<div class="col-sm-12">
			<div class="main-box news clearfix">
				<?php
				$image_col = 'col-sm-5';
				$text_col = 'col-sm-7';

				// Image is on the right on every other news
				if($i%2 == 0)
				{
					$image_col .= ' col-sm-push-7';
					$text_col .= ' col-sm-pull-5';
				}
				if($news_item->image_original_filename != "")
				{
					echo '<div class="'.$image_col.' news-image">';
					echo '<img src="'.base_url().'user_content/images/original/'.$news_item->image_original_filename.'" class="img-responsive" alt="Responsive image">';
					echo '</div>';
					echo '<div class="'.$text_col.' box-body">';
				}
				else
				{
					echo '<div class="col-sm-12 box-body">';
				}
				?>
					<h2>
						<?php echo anchor('news/view/'.$news_item->id.'/'.url_title($news_item->title, '-', true), $news_item->title, array("title" => $lang['news_tothenews'])); ?>
						<?php
						if($news_item->draft)
							echo '<span class="label label-default">'.$lang['misc_draft'].'</span>';
						?>
						<img src="<?php echo lang_id_to_imgpath($news_item->lang_id); ?>" class="img-circle pull-right" />
					</h2>
					<h3>
						<?php echo $lang['misc_published']; ?>
						<i class="date" title="<?php echo $news_item->date; ?>">
							<?php echo strtolower(readable_date($news_item->date, $lang));?>
						</i>
						<?php echo $lang['misc_by'].' '.anchor('user/profile/'.$news_item->userid, $news_item->first_name.' '.$news_item->last_name); ?>
					</h3>
					<p>
						<?php echo $news_story; ?>... <?php echo anchor('news/view/'.$news_item->id.'/'.url_title($news_item->title, '-', true), $lang['misc_readmore'].'!');?>
					</p>
				</div>
			</div>
		</div>
	</div> <!-- /.row -->
	<div class="row">
	<?php

	// increment counter
	$i++;
}
echo 	'</div>'; // row

?>
<div class="row">
	<div class="col-sm-12">
		<p>
			<?php echo anchor('news/archive', $lang['news_more'].' &rarr;', 'class="pull-right"'); ?>
		</p>
	</div>
</div>

