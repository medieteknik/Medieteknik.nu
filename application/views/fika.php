<?php
$group = end($group_years);
?>
<div class="main-box box-body clearfix">
		<h2><?php echo "Fika" ?></h2>
		<?php echo "Fikaschema för styrelsen!" ?>
		<div class="row">
			<div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-6 group-member">
				<div class="row">
					<div class="col-sm-12 col-xs-4">
						<p>
							<?php
							$date = new DateTime();
							$week = $date->format("W");
							$index = $week%count($group->members);
							$fikaBoss = $group->members[$index];
							echo anchor('user/profile/'.$fikaBoss->user_id,gravatarimg($fikaBoss, 400, ' class="img-responsive img-circle"'));
							?>
						</p>
					</div>
					<div class="col-sm-12 col-xs-8">
						<p>
							<strong>Fika-ansvarig</strong> &ndash;
							<?php echo anchor('user/profile/'.$fikaBoss->user_id, get_full_name($fikaBoss)); ?>
						</p>
						<p>
							<?php echo ($fikaBoss->email ? mailto($fikaBoss->email) : ''); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
</div>
