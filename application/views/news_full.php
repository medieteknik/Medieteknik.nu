<?php

$img_div = '';
$lang_img = '';

if($news->image_original_filename != "") {
	
	$ratio = news_size_to_px($news->size) / $news->height;
	$h = news_size_to_px(4) / $ratio;
	if($h > 400) $h = 400;
	
	$image = new imagemanip($news->image_original_filename, 'zoom', news_size_to_px(4), $h);
	$img_div = '<img src="'.$image.'" />';
	$lang_img = '<img src="'.lang_id_to_imgpath($news->lang_id).'" alt="flag" class="news_flag" />';
}

echo '<div class="main-box news clearfix">';
	echo $lang_img,$img_div;
	echo '<h2>'.$news->title.'</h2>';
	echo '<p>'.readable_date($news->date,$lang).'</p>';
	echo text_format($news->text);
	if($news->last_edit != '0000-00-00 00:00:00') {
		echo '<p>', $lang['news_lastedit'],' ', readable_date($news->last_edit,$lang), '</p>';
	}
	//do_dump($news);
echo '</div>';


