<?php

$img_div = '';

if($news->image_original_filename != "") {
	
	$ratio = news_size_to_px($news->size) / $news->height;
	$h = news_size_to_px(4) / $ratio;
	if($h > 400) $h = 400;
	
	$image = new imagemanip($news->image_original_filename, 'zoom', news_size_to_px(4), $h);
	$img_div = '<img src="'.$image.'" />';
}

echo '<div class="main-box news clearfix">';
	echo $img_div;
	echo '<h2>'.$news->title.'</h2>';
	echo '<p>'.readable_date($news->date,$language).'</p>';
	echo '<p>'.$news->text.'</p>';
	//do_dump($news);
echo '</div>';


