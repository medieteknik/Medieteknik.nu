<?php
foreach($news_array as $news_item)
{
	$news_story = text_format($news_item->text);
	?>
	<div class="main-box box-body news clearfix">
		<h2>
			<?php echo anchor('news/view/'.$news_item->id.'/'.url_title($news_item->title, '-', TRUE), $news_item->title, array("title" => $lang['news_tothenews'])); ?>
			<?php
			if($news_item->draft)
				echo '<span class="label label-default">'.$lang['misc_draft'].'</span>';
			?>
			<img src="<?php echo lang_id_to_imgpath($news_item->lang_id); ?>" class="img-circle pull-right" />
		</h2>
		<h3>
			<?php echo $lang['misc_published']; ?>
			<i class="date" title="<?php echo $news_item->date; ?>">
				<?php echo readable_date($news_item->date, $lang); ?>
			</i>
			<?php echo $lang['misc_by'].' '.anchor('user/profile/'.$news_item->userid, $news_item->first_name.' '.$news_item->last_name); ?>
		</h3>
		<?php echo $news_story; ?>
	</div>
	<?php
}

$total_pages = floor($news_count / $news_limit)+1;
$prev_page = $news_page == 1 ? 1 : $news_page-1;
$next_page = $news_page == $total_pages ? $total_pages : $news_page+1;

$threshold = 3;
?>
<ul class="pagination center-block">
	<li<?php echo $news_page == 1 ? ' class="disabled"' : '';?>>
		<?php echo anchor('news/archive/page/'.$prev_page.'/'.$news_limit, '&laquo;'); ?>
	</li>

	<?php
		$start = $news_page-$threshold > 0 ? $news_page-$threshold : 1;
		$end = $news_page+$threshold <= $total_pages ? $news_page+$threshold : $total_pages;

		if($news_page > $threshold+1)
		{
			echo '<li>'.anchor('news/archive/page/1/'.$news_limit, 1).'</li>';
			echo '<li class="disabled">'.anchor('#', '...', 'onClick="return false;"');'</li>';
		}

		for($k = $start; $k <= $end; $k++)
		{
			?>
			<li<?php echo $k == $news_page ? ' class="active"' : '';?>>
				<?php echo anchor('news/archive/page/'.$k.'/'.$news_limit, $k); ?>
			</li>
			<?php
		}

		if($news_page < $total_pages-$threshold)
		{
			echo '<li class="disabled">'.anchor('#', '...', 'onClick="return false;"');'</li>';
			echo '<li>'.anchor('news/archive/page/'.$total_pages.'/'.$news_limit, $total_pages).'</li>';
		}
	?>

	<li<?php echo $news_page == $total_pages ? ' class="disabled"' : '';?>>
		<?php echo anchor('news/archive/page/'.$next_page.'/'.$news_limit, '&raquo;'); ?>
	</li>
</ul>
