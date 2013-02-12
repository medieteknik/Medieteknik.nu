<?php 
foreach($news_array as $news_item) 
{
	//do_dump($news_item);
	$img_div = "";
	$news_class = "";
	$style = "";
	if($news_item->image_original_filename != "") 
	{
		$image = new imagemanip();
		$image->create($news_item->image_original_filename, 'zoom', news_size_to_px($news_item->size), $news_item->height);
		

		$img_div = '<img class="'.news_size_to_class($news_item->size).'" src="'.$image->get_filepath().'" alt="'.$news_item->title.'" />';
		$news_class = news_size_to_class_invert($news_item->size);
		$style = 'max-height:'.$news_item->height.'px; overflow: hidden;';
	}
	
	$lang_img = '<img src="'.lang_id_to_imgpath($news_item->lang_id).'" alt="flag" class="news_flag" />';
	$news_div = '<div style="'.$style.'" class="'.$news_class.'">'.$lang_img.'<h2>'.$news_item->title.'</h2><p>'.text_format($news_item->text, '<p>','</p>', FALSE).'</p></div>';
	
	$story = "";
	if($news_item->position == 1 || $news_item->size == 4) 
	{
		$story = $img_div.$news_div;
	} else {
		$story = $news_div.$img_div;
	}
	echo anchor('news/view/'.$news_item->id, $story, array("class" => "main-box news clearfix", "title" => $lang['news_tothenews'] ));
}