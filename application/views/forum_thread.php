<?php 
//do_dump($topic);
render_breadcrumbs($ancestors_array);
render_forum($categories_array);

$first = array_shift($replies);
echo '<div class="main-box clearfix">',
		'<h2>',text_strip($topic->topic),'</h2>',
		'<p>',text_format($first->reply),'</p>',
		'<p>',anchor('user/profile/'.$first->user_id,get_full_name($first)),'</p>
	</div>
';
foreach($replies as $reply) 
{
echo '
	<div class="main-box clearfix">',
		'<p>',text_format($reply->reply),'</p>',
		'<p>',anchor('user/profile/'.$reply->user_id,get_full_name($reply)),'</p>
	</div>
';
}

if(isset($postform)) 
{
	echo '<div class="main-box clearfix">';
	if(isset($guest)) 
	{
		echo 'Gästformulär';
	} else {
            
		echo '<h2>Post reply</h2>',
		form_open('forum/post_reply'),
		
		form_hidden(array('cat_id' => $categories_array[0]->id)),
		form_hidden(array('topic_id' => $topic->id)),
		form_hidden(array('guest' => 0)),
		
		form_label($lang['misc_text'], 'reply'),
		form_textarea(array('name' => 'reply',
							'id' => 'reply',
							'rows'	=>	10,
							'cols'	=>	85)),
		
		form_submit('post', 'Send');
		form_close();
	}
	echo '</div>';

}
