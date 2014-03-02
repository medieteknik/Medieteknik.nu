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
		echo $lang['misc_by'].' '.anchor('user/profile/'.$first->user_id, $user);
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
	<div class="main-box clearfix forum-view">
		<p><?php echo text_format($reply->reply); ?></p>
		<h3>
			<?php
			$user = gravatarimg($reply->gravatar, 30, 'class="img-circle"').' '.get_full_name($reply);
			echo $lang['misc_by'].' '.anchor('user/profile/'.$reply->user_id, $user);
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
