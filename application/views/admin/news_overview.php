<?php
echo '	<div class="main-box clearfix">
			<h2>',$lang['admin_addnews'],'</h2>
			<p>',anchor('admin_news/create', 'Skapa en nyhet genom att klicka här'),'</p>
		</div>';


echo '	<div class="main-box clearfix">
			<h2>',$lang['menu_admin'],'</h2>';
foreach($news_array as $news) {
		echo $news->date . ' ' . $news->draft . ' ' . $news->approved . ' ' . $news->sticky_order . '<br/>';
		foreach($news->translations as $translation) {
				if(empty($translation->title)) {
					echo $translation->language_name , ': ' , anchor('admin_news/edit/'.$translation->id,'['.$lang['admin_addtranslation'].']'),'<br/>';
				} else {
					echo $translation->language_name , ': ' , anchor('admin_news/edit/'.$translation->id,$translation->title),'<br/>';
				}
				//do_dump($news);
		}
		echo '<br/>';
}
			
echo '	</div>';
