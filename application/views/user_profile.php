<?php
// empty variable
$editbutton = "";

// check if user is viewing it's own profile
if($is_logged_in) {
	$editbutton = '<i>'.anchor('/user/edit_profile/', $lang['profile_edit']).'</i>';
}

$readweb = str_replace(array('http://', 'https://'), '', $user->web);

?>
<div class="main-box clearfix profile">
	<div class="row">
		<div class="col-sm-3">
			<p><?php echo gravatarimg($user, 300, ' class="img-responsive img-circle"'); ?></p>
		</div>
		<div class="col-sm-9">
			<h3><?php echo get_full_name($user),' ',$editbutton; ?></h3>
			<ul class="profilelinks list-inline">
				<?php echo ($user->linkedin ? '<li><a href="'.$user->linkedin.'" target="_blank">Linkedin</a></li>': ''); ?>
				<?php echo ($user->twitter ? '<li><a href="https://twitter.com/'.$user->twitter.'" target="_blank">Twitter <i>@'.$user->twitter.'</i></a></li>': ''); ?>
				<?php echo ($user->web ? '<li><a href="'.$user->web.'" target="_blank">'.$readweb.'</a></li>': ''); ?>
				<li><a href="mailto:<?php echo $user->lukasid; ?>@student.liu.se" target="_blank">
					<i><?php echo $user->lukasid; ?>@student.liu.se</i>
				</a></li>
			</ul>
			<p><?php echo text_format($user->presentation); ?></p>
		</div>
	</div>
</div><!-- close .main-box -->

<?php
$boxes = 0;
if(count($user->forum_posts) > 0)
	$boxes++;
if(count($user->groups) > 0)
	$boxes++;
if(count($user->news) > 0)
	$boxes++;
?>

<div class="row">
	<div class="col-sm-6">
		<?php
		if(count($user->forum_posts) > 0)
		{
			?>
			<div class="main-box clearfix margin-top">
				<h4><?php echo $lang['user_profile_posts'].' '.$user->first_name; ?></h4>
				<ul class="list-unstyled box-list">
					<?php
					foreach ($user->forum_posts as $post) {
						?>
						<li>
							<?php echo anchor('forum/thread/'.$post->topic_id.'#replyid-'.$post->reply_id, '<strong>'.$post->topic.'</strong><span>'.readable_date($post->reply_date,$lang).'</span>'); ?>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
			<?php
		}
		?>
		<?php
		if(count($user->groups) > 0)
		{
			echo $boxes == 2 ? '</div><div class="col-sm-6">' : '';
			?>
				<div class="main-box clearfix margin-top">
					<h4><?php echo $lang['user_profile_groups']; ?></h4>
					<ul class="list-unstyled box-list">
						<?php
						foreach ($user->groups as $group) {
							?>
							<li>
								<?php echo '<strong>'.$group->name.'</strong> '.$group->start_year.'/'.$group->stop_year.', '.$group->position; ?>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			<?php
		}
		?>
	</div>
	<?php
	if(count($user->news) > 0)
	{
	?>
		<div class="col-sm-6">
			<div class="main-box clearfix margin-top">
				<h4><?php echo $lang['user_profile_news'].' '.$user->first_name; ?></h4>
				<div class="profile-news">
					<?php
					foreach ($user->news as $news)
					{
						$news_story = news_excerpt(text_format($news->text, '<p>','</p>', FALSE), 100);
						?>
						<div class="entry">
							<h4>
								<?php echo anchor('news/view/'.$news->id, $news->title); ?>
								<small><?php echo readable_date($news->date, $lang); ?></small>
							</h4>
							<p>
								<?php echo $news_story; ?>...
								<?php echo anchor('news/view/'.$news->id, $lang['misc_readmore'].'!', 'class="inline"');?>
							</p>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	<?php
	}
	?>
</div>
