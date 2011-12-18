<h1><?php echo $news_title; ?></h1>

<?php 
foreach($news_array as $news_item) {
	echo '<div class="news_item">';
		echo '<h2>'.$news_item->title.'</h2>';
		echo '<p>'.$news_item->text.'</p>';
		echo '<p>'.$news_author.': '.get_full_name($news_item).'</p>';
		echo '<p>'.readable_date($news_item->date, $common_lang).'</p>';
	echo '</div>';
}
?>