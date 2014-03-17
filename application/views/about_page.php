<div class="main-box clearfix">
	<?php
	foreach($content as $page){
		?>
		<h2><?php echo $page->header; ?></h2>
		<?php echo text_format($page->content); ?>

		<?php
		if($page->name !== "404")
		{
			?>
			<div class="metadata">
				<p><i><?php echo $lang['misc_last_update'], " ", strtolower(readable_date($page->last_edit, $lang)); ?></i></p>
			</div>
			<?php
		}
	}
	?>
</div>
