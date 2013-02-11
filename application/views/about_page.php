<div class="main-box clearfix">
	<?php
	foreach($content as $page){
		echo "
		<h2>",$page->header,"</h2>",text_format($page->content), "<p><i>", $lang['misc_last_update'], " ", strtolower(readable_date($page->last_edit, $lang)),"</i></p>";
	}
	
	?>
</div>
