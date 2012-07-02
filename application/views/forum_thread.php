
<?php 
echo '<h1>'.$topic->topic.'</h1>';
foreach($replies as $reply) {
	echo '<div class="main-box clearfix">';
	echo text_format($reply->reply, 'p');
	echo '<p>'.anchor('user/profile/'.$reply->user_id,get_full_name($reply)).'</p>';
	//echo '<pre>';
	//var_dump($reply);
	//echo '</pre>';
	echo '</div>';
}
