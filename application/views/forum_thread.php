<?php
// do_dump($replies);
// do_dump($topic);

$first = array_shift($replies);
?>
<div class="main-box clearfix forum-view">
	<?php
		render_breadcrumbs($ancestors_array);
		render_forum($categories_array);
	?>
	<h2 id="replyid-<?php echo $first->id; ?>">
		<?php echo text_strip($topic->topic); ?>
	</h2>
	<p><?php echo text_format($first->reply); ?></p>
	<h3>
		<?php
		$user = gravatarimg($first->gravatar, 30, 'class="img-circle"').' '.get_full_name($first);
		echo anchor('user/profile/'.$first->user_id, $user);
		?>,
		<a href="#replyid-<?php echo $first->id; ?>" title="<?php echo $first->reply_date; ?>">
			<?php echo readable_date($first->reply_date, $lang); ?>
		</a>
	</h3>
</div>

<?php
foreach($replies as $reply)
{
	?>
	<div class="main-box clearfix forum-view margin-top" id="replyid-<?php echo $reply->id; ?>">
		<p><?php echo text_format($reply->reply); ?></p>
		<h3>
			<?php
			$user = gravatarimg($reply->gravatar, 30, 'class="img-circle"').' '.get_full_name($reply);
			echo anchor('user/profile/'.$reply->user_id, $user);
			?>,
			<a href="#replyid-<?php echo $reply->id; ?>" title="<?php echo $reply->reply_date; ?>">
				<?php echo readable_date($reply->reply_date, $lang); ?>
			</a>
		</h3>
	</div>
	<?php
}

if(isset($postform))
{
	echo '<div class="main-box clearfix forum-view margin-top">';
	if(isset($guest))
	{
		echo 'Gästformulär';
	}
	else
	{
		echo '<h2>'.$lang['forum_answer'].'</h2>';

		echo '<div class="row">',
			form_open('forum/post_reply'),

				form_hidden(array('cat_id' => $categories_array[0]->id)),
				form_hidden(array('topic_id' => $topic->id)),
				form_hidden(array('guest' => 0)),
				'<div class="col-sm-8"><p>',
					// good praxis to allways add a label. Bootstraps' .sr-only will hide it since we use placeholders.
					form_label($lang['misc_text'], 'reply', array('class' => 'sr-only')),
					form_textarea(array('name' => 'reply',
										'id' => 'reply',
										'rows'	=>	6,
										'class' => 'form-control',
										'placeholder' => $lang['misc_text'].'...',
										'required' 	=> '')),
				'</p></div>',
				'<div class="col-sm-4">',
					'<p><input type="submit" name="post" value="',$lang['forum_submit'],'" class="btn btn-success form-control" /></p>',
					'<p>',$lang['forum_guidelines'],'</p>',
				'</div>',
			form_close(),
		'</div>';
	}
	echo '</div>';

}
