<?php 

echo '<h1>', $topic->topic, '</h1>';

foreach($replies as $reply) {
echo '
	<div class="main-box clearfix">',
		text_format($reply->reply, 'p'),
		'<p>',anchor('user/profile/'.$reply->user_id,get_full_name($reply)),'</p>
	</div>
';
}
