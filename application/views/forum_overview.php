<?php 

//do_dump($categories_array);


echo '<div class="main-box clearfix">';
render_forum($categories_array);
if(count($topics_array) > 0) 
{
	echo '<ul class="topics">';
	
	foreach($topics_array as $topic) 
	{
		echo '<li>',anchor('forum/thread/'.$topic->topic_id,text_strip($topic->topic)),'</li>';
	}
	
	echo '</ul>';
	
	
	//do_dump($thread_array);
} else if(isset($postform)) 
{
	echo '<p>Inga trådar</p>';
}
echo '</div>';

if(isset($postform)) 
{
	echo '<div class="main-box clearfix">';
	if(isset($guest)) 
	{
		echo 'Gästformulär';
	} else {
            
		echo '<h2>Post topic</h2>',
		form_open('forum/post_topic'),
		
		form_hidden(array('cat_id' => $categories_array[0]->id)),
		form_hidden(array('guest' => 0)),
		
		form_label($lang['misc_headline'], 'topic'),
		form_input(array('name' => 'topic','id' => 'topic')),
		
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
