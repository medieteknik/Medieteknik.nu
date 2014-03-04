<?php
echo '
<div class="row">
	<div class="col-sm-6">
		<div class="main-box clearfix">
			<h4>Status</h4>
			<ul class="list-unstyled">
				<li><strong>',$notifications->news_published,'</strong> ',$lang['admin_news_published'],'</li>
				<li><strong>',$notifications->news_draft,'</strong> ',$lang['admin_news_drafts'],'</li>
				<li><strong>',$notifications->news_unapproved,'</strong> ',$lang['admin_news_needsapproval'],'</li>
			</ul>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="main-box clearfix">
			<h4>',$lang['admin_addnews'],'</h4>
			<p>',anchor('admin_news/create', $lang['admin_news_create']),'</p>
		</div>
	</div>
</div>
<!--<h4>',$lang['menu_archive'],'</h4>-->
';


foreach($news_array as $news) {
	?>
	<div class="main-box clearfix admin-news-entry margin-top">
		<div class="row">
			<div class="col-sm-4">
				<h4>
					<?php
					echo anchor('admin_news/edit/'.$news->id, $lang['misc_edit']);
					if($news->sticky_order)
						echo ' <span class="label label-danger">'.$lang['admin_news_sticky'].'</span>';
					if(!$news->approved)
						echo ' <span class="label label-warning">'.$lang['misc_pending'].'</span>';
					if($news->draft)
						echo ' <span class="label label-default">'.$lang['misc_draft'].'</span>';
					?>
				</h4>
				<h5>
					<?php
					echo (($news->approved && !$news->draft ) ? $lang['misc_postdate'] : $lang['misc_created']).
						': '. readable_date($news->date, $lang);
					?>
				</h5>
				<p>
					<?php
					echo $lang['misc_createdby'].' '.anchor('user/profile/'.$news->user_id, get_full_name($news)).'.';
					?>
				</p>
			</div>
			<?php
			foreach ($news->translations as $translation) {
				?>
				<div class="col-sm-4">
					<h4>
						<?php echo $translation->title; ?>
						<img src="<?php echo lang_id_to_imgpath($translation->lang_id); ?>" class="img-circle">
					</h4>
					<p>
						<?php echo news_excerpt(text_format($translation->text), 130); ?>
					</p>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php


/*	$img_div = '';
	if($news->image_original_filename != "") {
		$image = new imagemanip($news->image_original_filename, 'fit', 300, 100);
		$img_div = '<img src="'.$image.'" style="float:right;" />';
	}

	$classes = '';
	if($news->draft == 1 || $news->approved == 0) {
		$classes = ' red';
	}

	$content = $img_div.'<h2>'.$lang['misc_postdate']. ': '. readable_date($news->date,$lang). '</h2><p>';
	foreach($news->translations as $translation) {
		if(empty($translation->title)) {
			$content .= $translation->language_name. ': '. $lang['admin_addtranslation'].'<br/>';
		} else {
			$content .= $translation->language_name. ': '. $translation->title. '<br/>';
		}
	}
	$content .= '</p>';

	echo anchor('admin_news/edit/'.$translation->id, $content, array("class" => "main-box news clearfix" . $classes, "title" => $lang['news_editthenews'] ));
*/

	/*echo '
	<div class="main-box clearfix ', $classes,'">',
		// $img_div,
		'<h2>',$lang['misc_published'], ': ', $news->date, '</h2><p>';
		foreach($news->translations as $translation) {
			if(empty($translation->title)) {
				echo $translation->language_name , ': ' , anchor('admin_news/edit/'.$translation->id,'['.$lang['admin_addtranslation'].']'),'<br/>';
			} else {
				echo $translation->language_name , ': ' , anchor('admin_news/edit/'.$translation->id,$translation->title),'<br/>';
			}
		}
		echo '</p>
	</div>';*/
}

// do_dump($news_array);
