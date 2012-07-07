<?php
echo '
<div class="main-box clearfix">
	<h2>',$lang['admin_addnews'],'</h2>
	<p>',anchor('admin_news/create', 'Skapa en nyhet genom att klicka här'),'</p>
</div>
<h2>',$lang['menu_archive'],'</h2>		
';



foreach($news_array as $news) {
		//do_dump($news);
	$img_div = '';
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

	/*
	echo '
	<div class="main-box clearfix ', $classes,'">',
		$img_div,
		'<h2>',$lang['misc_published'], ': ', $news->date, '</h2><p>';
		foreach($news->translations as $translation) {
			if(empty($translation->title)) {
				echo $translation->language_name , ': ' , anchor('admin_news/edit/'.$translation->id,'['.$lang['admin_addtranslation'].']'),'<br/>';
			} else {
				echo $translation->language_name , ': ' , anchor('admin_news/edit/'.$translation->id,$translation->title),'<br/>';
			}
		}
		echo '</p>
	</div>';
	*/
}
			
