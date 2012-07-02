<?php 
echo '<div class="main-box news clearfix">';
	echo '<h2>'.$news->title.'</h2>';
	echo '<p>'.readable_date($news->date,$language).'</p>';
	echo '<p>'.$news->text.'</p>';
echo '</div>';


