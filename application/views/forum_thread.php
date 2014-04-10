<?php
// do_dump($replies);
do_dump($topic);
// do_dump($count_replies);

if(isset($post_data) && $post_data == 'verify')
{
	echo '<div class="alert alert-success"><strong>'.$lang['forum_guest_verify'].'</strong> '.$lang['forum_guest_verify_info'].'</div>';
}

$first = array_shift($replies);
?>
<div class="main-box box-body clearfix forum-view forum-reply">
	<?php
		render_breadcrumbs($ancestors_array);
		render_forum($categories_array);
	?>
	<h2 id="replyid-<?php echo $first->id; ?>">
		<?php echo text_strip($topic->topic); ?>
	</h2>
	<?php echo text_format($first->reply); ?>
	<div class="metadata">
		<p>
			<?php
			if($first->user_id == 0)
			{
				echo gravatarimg($first->email, 30, 'class="img-circle"').' '.$lang['misc_guest'].': '.$first->name;
			}
			else
			{
				$user = gravatarimg($first->gravatar, 30, 'class="img-circle"').' '.get_full_name($first);
				echo anchor('user/profile/'.$first->user_id, $user);
			}
			?>,
			<a href="#replyid-<?php echo $first->id; ?>" title="<?php echo $first->reply_date; ?>">
				<?php echo strtolower(readable_date($first->reply_date, $lang)); ?>
			</a>

			<?php
			if($this->login->is_logged_in() && $this->login->get_id() !== $first->user_id)
			{
				if(count($first->reports) == 0)
				{
					?>
					<span class="report">
						<span class="glyphicon glyphicon-exclamation-sign"></span>
						<a href="#" class="toggle">
							<?php echo $lang['forum_report']; ?>
						</a>
						<a href="#" class="hidden confirm" data-id="<?php echo $first->id; ?>">
							<?php echo $lang['forum_report_confirm']; ?>!
						</a>
						<span class="thanks hidden"><?php echo $lang['forum_report_thanks']; ?></span>
					</span>
					<?php
				}
				else
				{
					?>
					<span class="report">
						<span class="glyphicon glyphicon-exclamation-sign"></span>
						<?php echo $lang['forum_report_thanks']; ?>
					</span>
					<?php
				}
			}
			?>
		</p>
	</div>
</div>

<?php
$count = 0;
$break = 7;
foreach($replies as $reply)
{
	if($count == $break && !(isset($post_data) && $post_data == 'all'))
	{
		?>
		<p class="text-center" id="forum-load">
			<?php
			echo anchor('/forum/thread/'.$topic->id.'/all',
				'<span class="glyphicon glyphicon-comment"></span> '.$lang['forum_loadmore'],
				array('data-thread' => $topic->id, 'class' => 'btn btn-default forum-load'));
			?>
		</p>
		<?php
	}
	?>

	<div class="main-box box-body clearfix forum-view
		margin-top forum-reply<?php echo ($count > $count_replies-$break || (isset($post_data) && $post_data == 'all')) ? '' : ' hidden'; ?>" id="replyid-<?php echo $reply->id; ?>">
		<p><?php echo text_format($reply->reply); ?></p>
		<div class="metadata">
			<p>
				<?php
				if($reply->user_id == 0)
				{
					echo gravatarimg($reply->email, 30, 'class="img-circle"').' '.$lang['misc_guest'].': '.$reply->name;
				}
				else
				{
					$user = gravatarimg($reply->gravatar, 30, 'class="img-circle"').' '.get_full_name($reply);
					echo anchor('user/profile/'.$reply->user_id, $user);
				}
				?>,
				<a href="<?php echo base_url('/forum/thread/'.$topic->id.'/all'); ?>#replyid-<?php echo $reply->id; ?>" title="<?php echo $reply->reply_date; ?>">
					<?php echo strtolower(readable_date($reply->reply_date, $lang)); ?>
				</a>
				<?php
				if($this->login->is_logged_in() && $this->login->get_id() !== $reply->user_id)
				{
					if(count($reply->reports) == 0)
					{
						?>
						<span class="report">
							<span class="glyphicon glyphicon-exclamation-sign"></span>
							<a href="#" class="toggle">
								<?php echo $lang['forum_report']; ?>
							</a>
							<a href="#" class="hidden confirm" data-id="<?php echo $reply->id; ?>">
								<?php echo $lang['forum_report_confirm']; ?>!
							</a>
							<span class="thanks hidden"><?php echo $lang['forum_report_thanks']; ?></span>
						</span>
						<?php
					}
					else
					{
						?>
						<span class="report">
							<span class="glyphicon glyphicon-flag"></span>
							<?php echo $lang['forum_report_thanks']; ?>
						</span>
						<?php
					}
				}
				?>
			</p>
		</div>
	</div>
	<?php
	$count++;
}

if(isset($postform))
{
	echo '<div class="main-box box-body clearfix forum-view margin-top">';
	if(isset($guest))
	{
		?>
		<h2><?php echo $lang['forum_guest_reply_form']; ?></h2>
		<?php
		if(is_array($post_data) && isset($post_data['message']) && $post_data['message'] == 'fail')
			echo '<div class="alert alert-danger">'.$lang['forum_guest_reply_error'].'</div>';
		?>
		<?php echo form_open('forum/post_reply'); ?>
			<?php
			echo form_hidden(array('cat_id' => $categories_array[0]->id)),
				form_hidden(array('topic_id' => $topic->id)),
				form_hidden(array('guest' => 1));
			?>
			<div class="row">
				<div class="col-sm-8">
					<p>
						<?php
						echo form_label($lang['misc_text'], 'reply', array('class' => 'sr-only')),
							form_textarea(array('name' 		=> 'reply',
												'id' 		=> 'reply',
												'rows'		=>	8,
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
						<input type="submit" name="post" value="<?php echo $lang['forum_submit']; ?>" class="btn btn-success form-control" />
					</p>
					<p>
						<?php echo $lang['forum_guidelines']; ?>
					</p>
				</div>
			</div>
		<?php echo form_close(); ?>
		<?php
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
