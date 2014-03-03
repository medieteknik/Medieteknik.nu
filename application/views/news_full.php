<?php

// $img_div = '';
// $lang_img = '';

// if($news->image_original_filename != "")
// {

// 	$ratio = news_size_to_px($news->size) / $news->height;
// 	$h = news_size_to_px(4) / $ratio;
// 	if($h > 400) $h = 400;

// 	$image = new imagemanip($news->image_original_filename, 'zoom', news_size_to_px(4), $h);
// 	$img_div = '<img src="'.$image.'" />';
// 	$lang_img = '<img src="'.lang_id_to_imgpath($news->lang_id).'" alt="flag" class="news_flag" />';
// }

// echo '
// <div class="main-box news clearfix">',
// $lang_img,$img_div,
// '<h2>'.text_strip($news->title).'</h2>
// <p>',readable_date($news->date,$lang),'</p>',
// text_format($news->text);
// if($news->last_edit != '0000-00-00 00:00:00')
// {
// 	echo '<p>',$lang['news_lastedit'],' ', readable_date($news->last_edit,$lang), '</p>';
// }
// echo '</div>';

	$news_story = text_format($news->text, '<p>','</p>', FALSE);
	?>
	<div class="main-box news clearfix">
		<h1>
			<?php echo $news->title; ?>
			<img src="<?php echo lang_id_to_imgpath($news->lang_id); ?>" class="img-circle pull-right" />
		</h1>
		<h3>
			<?php echo $lang['misc_published']; ?>
			<i class="date" title="<?php echo $news->date; ?>">
				<?php echo readable_date($news->date, $lang); ?>
			</i>
			<?php echo $lang['misc_by'].' '.anchor('user/profile/'.$news->userid, $news->first_name.' '.$news->last_name); ?>
		</h3>
		<?php echo $news_story; ?>
	</div>
	<?php
