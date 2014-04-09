<?php
$most_recent_group = end($group_years);
//do_dump($group);
?>
<div class="main-box box-body clearfix">
	<?php
	foreach($groups as $group)
	{
		?>
		<h2><?php echo $group->name; ?></h2>
		<?php echo text_format($group->description); ?>
		<div class="row">
			<?php
			$i = 0;
			foreach ($group->members as $member)
			{
				if($member->start_year == $most_recent_group->start_year)
				{
					if($i%4 == 0 && $i !== 0)
						echo '</div><!-- new row! --><div class="row">';

					?>
					<div class="col-sm-3 col-xs-6">
						<p>
							<?php echo gravatarimg($member, 400, ' class="img-responsive img-circle"'); ?>
						</p>
						<p class="text-center">
							<strong><?php echo $member->position; ?></strong> &ndash;
							<?php echo anchor('user/profile/'.$member->user_id, get_full_name($member)); ?>
						</p>
						<p class="text-center">
							<?php echo ($member->email ? mailto($member->email) : ''); ?>
						</p>
					</div>
					<?php
					$i++;
				}
			}
			?>
		</div>
		<?php
	}
	?>
</div>
