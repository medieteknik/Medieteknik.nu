<?php 
foreach($news_array as $news_item) 
{
	//do_dump($news_item);
	$img_div = "";
	$news_class = "";
	//$style = "";
	if($news_item->image_original_filename != "") 
	{
		$image = new imagemanip();
		$image->create($news_item->image_original_filename, 'zoom', news_size_to_px($news_item->size), $news_item->height);
		

		$img_div = '<img class="'.news_size_to_class($news_item->size).'" src="'.$image->get_filepath().'" alt="'.$news_item->title.'" />';
		$news_class = news_size_to_class_invert($news_item->size);
		//$style = 'max-height:'.$news_item->height.'px; overflow: hidden;';
	}
	
	$lang_img = '<img src="'.lang_id_to_imgpath($news_item->lang_id).'" alt="flag" class="news_flag" />';
	//$news_div = '<div style="'.$style.'" class="'.$news_class.'">'.$lang_img.'<h2>'.$news_item->title.'</h2><p>'.text_format($news_item->introduction, '<p>','</p>', FALSE).'</p></div>';
	$news_div = '<div class="'.$news_class.'">'.$lang_img.'<h2>'.anchor('news/view/'.$news_item->id, $news_item->title, array("title" => $lang['news_tothenews'] )).'</h2>'.text_format($news_item->introduction, '<p>','</p>', FALSE).'<p>'.anchor('news/view/'.$news_item->id, $lang['news_readmore']).'</p></div>';
	
	/*
	$story = "";
	if($news_item->position == 1 || $news_item->size == 4) 
	{
		$story = $img_div.$news_div;
	} else {
		$story = $news_div.$img_div;
	}
	echo anchor('news/view/'.$news_item->id, $story, array("class" => "main-box news clearfix", "title" => $lang['news_tothenews'] ));
	*/

	echo '<div class = "main-box news clearfix">';
	// No image
	if($news_item->image_original_filename == ""){
		echo $news_div;
	}
	// Image left or above
	else if($news_item->position == 1 || $news_item->size == 4) 
	{
		echo anchor('news/view/'.$news_item->id, $img_div, array("title" => $lang['news_tothenews'] ));
		echo $news_div;
	}
	// Image right
	else {
		echo $news_div;
		echo anchor('news/view/'.$news_item->id, $img_div, array("title" => $lang['news_tothenews'] ));
	}

	echo '</div>';
	
	
}