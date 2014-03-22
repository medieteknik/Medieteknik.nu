<?php

// do_dump($categories_array);
// do_dump($ancestors_array);

echo '<div class="main-box box-body clearfix forum-view">';

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
				strtolower(readable_date($topic->reply_date, $lang)).
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
	echo '<div class="main-box box-body clearfix forum-view margin-top">';
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
										   'required' => '',
										   'value' => (is_array($post_data) && isset($post_data['topic']) ? $post_data['topic'] : ''))),
					'</p>',
					// good praxis to allways add a label. Bootstraps' .sr-only will hide it since we use placeholders.
					form_label($lang['misc_text'], 'reply', array('class' => 'sr-only')),
					form_textarea(array('name' 		=> 'reply',
										'id' 		=> 'reply',
										'rows'		=>	6,
										'class'		=> 'form-control',
										'placeholder' => $lang['misc_text'].'...',
										'required' 	=> '',
									    'value' => (is_array($post_data) && isset($post_data['reply']) ? $post_data['reply'] : ''))),
				'</p></div>',
				'<div class="col-sm-4">',
					'<p><input type="submit" name="post" value="',$lang['forum_createtopic'],'" class="btn btn-success form-control" /></p>',
					'<p>',$lang['forum_guidelines'],'</p>',
				'</div>',
			form_close(),
		'</div>';
	}
	else if(!$is_logged_in && $guest_allowed)
	{
		?>
		<h2><?php echo $lang['forum_guest_form']; ?></h2>
		<?php
		if(is_array($post_data) && isset($post_data['message']) && $post_data['message'] == 'fail')
			echo '<div class="alert alert-danger">'.$lang['forum_guest_topic_error'].'</div>';
		?>
		<?php echo form_open('forum/post_topic'); ?>
			<?php
			echo form_hidden(array('cat_id' => $categories_array[0]->id)),
				form_hidden(array('guest' => 1));
			?>
			<div class="row">
				<div class="col-sm-8">
					<p>
						<?php
						echo  form_label($lang['misc_headline'], 'topic', array('class' => 'sr-only')),
							form_input(array('name' => 'topic',
											   'id' => 'topic',
											   'class'=> 'form-control',
											   'placeholder' => $lang['misc_headline'],
											   'required' => '',
											   'value' => (is_array($post_data) && isset($post_data['topic']) ? $post_data['topic'] : '')));
						?>
					</p>
					<p>
						<?php
						echo form_label($lang['misc_text'], 'reply', array('class' => 'sr-only')),
							form_textarea(array('name' 		=> 'reply',
												'id' 		=> 'reply',
												'rows'		=>	6,
												'class'		=> 'form-control',
												'placeholder' => $lang['misc_text'].'...',
												'required' 	=> '',
										   		'value' => (is_array($post_data) && isset($post_data['reply']) ? $post_data['reply'] : '')));
						?>
					</p>
				</div>
				<div class="col-sm-4">
					<p>
						<?php
						echo  form_label($lang['forum_guest_name'], 'name', array('class' => 'sr-only')),
							form_input(array('name' => 'name',
											   'id' => 'name',
											   'class'=> 'form-control',
											   'placeholder' => $lang['forum_guest_name'],
											   'required' => '',
										   	   'value' => (is_array($post_data) && isset($post_data['name']) ? $post_data['name'] : '')));
						?>
					</p>
					<p>
						<?php
						echo  form_label($lang['forum_guest_email'], 'email', array('class' => 'sr-only')),
							form_input(array('name' => 'email',
											   'id' => 'email',
											   'class'=> 'form-control',
											   'placeholder' => $lang['forum_guest_email'],
											   'type' => 'email',
											   'required' => '',
										   	   'value' => (is_array($post_data) && isset($post_data['email']) ? $post_data['email'] : '')));
						?>
					</p>
					<p>
						<input type="submit" name="post" value="<?php echo $lang['forum_createtopic']; ?>" class="btn btn-success form-control" />
					</p>
					<p>
						<?php echo $lang['forum_guidelines']; ?>
					</p>
				</div>
			</div>
		<?php echo form_close(); ?>
		<?php
	}
	else if (!$is_logged_in && !$guest_allowed)
	{
		echo '<p class="bigmargin">'.$lang['forum_loginfirst'].'</p>';
	}
	echo '</div>';
}
