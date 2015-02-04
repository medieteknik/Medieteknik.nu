<div class="main-box box-body clearfix">
		<h2>Fika</h2>
		<p>Fikaschema för styrelsen!</p>
		<div class="row">
			<div class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-6 group-member">
				<div class="row">
					<div class="col-sm-8 col-xs-4">
						<p>
							<?php
							echo anchor('user/profile/'.$fika_boss->user_id,gravatarimg($fika_boss, 400, ' class="img-responsive img-circle"'));
							?>
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-10 col-xs-8">
						<p>
							<strong>Fika-ansvarig</strong> &ndash;
							<?php echo anchor('user/profile/'.$fika_boss->user_id, get_full_name($fika_boss)); ?>
						</p>
						<p>
							Nästa ansvarig &ndash;
							<?php echo anchor('user/profile/'.$next_fika_boss->user_id, get_full_name($next_fika_boss)); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
</div>
