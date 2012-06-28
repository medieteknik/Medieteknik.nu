
<?php 
echo '<h1>'.$topic->topic.'</h1>';
foreach($replies as $reply) {
	echo '<div class="main-box clearfix">';
	echo '<p>'.$reply->reply.'</p>';
	echo '</div>';
}
