<?php
echo '
<div class="row">
	<div class="col-sm-6">
		<div class="main-box box-body clearfix">
			<h4>Status</h4>
			<ul class="list-unstyled">
				<li><strong>',$notifications->news_published,'</strong> ',$lang['admin_news_published'],'</li>
				<li><strong>',$notifications->news_draft,'</strong> ',$lang['admin_news_drafts'],'</li>
				<li><strong>',$notifications->news_unapproved,'</strong> ',$lang['admin_news_needsapproval'],'</li>
			</ul>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="main-box box-body clearfix">
			<h4>',$lang['admin_addnews'],'</h4>
			<p>',anchor('admin/news/create', $lang['admin_news_create']),'</p>
		</div>
	</div>
</div>
<!--<h4>',$lang['menu_archive'],'</h4>-->
';


foreach($news_array as $news) {
	?>
	<div class="main-box box-body clearfix admin-news-entry margin-top">
		<div class="row">
			<div class="col-sm-4">
				<h4>
					<?php
					echo anchor('admin/news/edit/'.$news->id, $lang['misc_edit']);
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
}
