<?php

// do_dump($categories_array);
// do_dump($ancestors_array);

echo '<div class="main-box clearfix forum-view">';

if($ancestors_array)
	render_breadcrumbs($ancestors_array);

render_forum($categories_array);

if(count($topics_array) > 0)
{
	echo '<ul class="topics list-unstyled">';
	foreach($topics_array as $topic)
	{
		$topic_text = text_strip($topic->topic).
			' <span class="pull-right">'.
				get_full_name($topic).', '.
				readable_date($topic->reply_date, $lang).
			'</span>';
		echo '<li>',anchor('forum/thread/'.$topic->topic_id, $topic_text),'</li>';
	}
	echo '</ul>';
}
else if($posting_allowed === true)
{
	echo '<p class="bigmargin">'.$lang['forum_nothreads'].'</p>';
}

echo '</div>';

if($posting_allowed === true)
{
	echo '<div class="main-box clearfix forum-view margin-top">';
	if($is_logged_in)
	{
		echo '<h2>'.$lang['forum_posttopic'].'</h2>';

		echo '<div class="row">',
			form_open('forum/post_topic'),

				form_hidden(array('cat_id' => $categories_array[0]->id)),
				form_hidden(array('guest' => 0)),
				'<div class="col-sm-8">',
					// good praxis to allways add a label. Bootstraps' .sr-only will hide it since we use placeholders.
					form_label($lang['misc_headline'], 'topic', array('class' => 'sr-only')),
					'<p>',form_input(array('name' => 'topic',
										   'id' => 'topic',
										   'class'=> 'form-control',
										   'placeholder' => $lang['misc_headline'],
										   'required' => '')),
					'</p>',
					// good praxis to allways add a label. Bootstraps' .sr-only will hide it since we use placeholders.
					form_label($lang['misc_text'], 'reply', array('class' => 'sr-only')),
					form_textarea(array('name' 		=> 'reply',
										'id' 		=> 'reply',
										'rows'		=>	6,
										'class'		=> 'form-control',
										'placeholder' => $lang['misc_text'].'...',
										'required' 	=> '')),
				'</p></div>',
				'<div class="col-sm-4">',
					'<p><input type="submit" name="post" value="',$lang['forum_createtopic'],'" class="btn btn-success form-control" /></p>',
					'<p>',$lang['forum_guidelines'],'</p>',
				'</div>',
			form_close(),
		'</div>';
	}
	else if (!$is_logged_in && !$guest_allowed)
	{
		echo '<p class="bigmargin">'.$lang['forum_loginfirst'].'</p>';
	}
	else if(!$is_logged_in && $guest_allowed)
	{
		echo '<p>Gästforumlär</p>';
	}
	echo '</div>';
}
