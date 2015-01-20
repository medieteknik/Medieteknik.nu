<?php
$most_recent_group = end($group_years);
//do_dump($group);
?>
<div class="main-box box-body clearfix">
	<?php
	foreach($groups as $group)
	{
		?>
		<h2><?php echo $group->name . " " . substr($most_recent_group->start_year,2) . "/" . substr($most_recent_group->stop_year,2); ?></h2>
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
					<div class="col-md-3 col-sm-6 col-xs-12 group-member">
						<div class="row">
							<div class="col-sm-12 col-xs-4">
								<p>
									<?php
									echo anchor('user/profile/'.$member->user_id,gravatarimg($member, 400, ' class="img-responsive img-circle"'));
									?>
								</p>
							</div>
							<div class="col-sm-12 col-xs-8">
								<p>
									<strong><?php echo $member->position; ?></strong> &ndash;
									<?php echo anchor('user/profile/'.$member->user_id, get_full_name($member)); ?>
								</p>
								<p>
									<?php echo ($member->email ? mailto($member->email) : ''); ?>
								</p>
							</div>
						</div>
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
