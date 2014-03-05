<div class="row">
	<div class="col-sm-6">
		<div class="main-box clearfix profile">
			<h4><?php echo $lang['admin_editusers']; ?></h4>
			<form action="<?php echo site_url('admin/user/overview/search'); ?>" method="get">
				<ul class="list-unstyled">
					<li><?php echo '<strong>'.$notif->disabled.'</strong> '.$lang['admin_listusers_disabled']; ?></li>
					<li><?php echo '<strong>'.$notif->unapproved.'</strong> '.$lang['admin_listusers_unapproved']; ?></li>
					<li><?php echo '<strong>'.$notif->total.'</strong> '.$lang['admin_listusers_total']; ?></li>
				</ul>
				<p>
					<?php
					$searchinput = array(
										'name' 		=> 'q',
										'id'		=> 'q',
										'placeholder' => $lang['misc_typeandenter'],
										'class'		=> 'form-control',
              							'value'		=> (isset($query) ? $query : ''),
								   );
					echo form_label($lang['admin_searchusers'], 'q').form_input($searchinput);
					?>
				</p>
			</form>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="main-box clearfix profile">
			<h4><?php echo $lang['admin_addusers']; ?></h4>
			<p>
				<?php echo anchor('admin/user/add', $lang['admin_addusers']); ?>
			</p>
		</div>
	</div>
</div>
<div class="main-box clearfix margin-top">
	<h3>
		<?php
		echo isset($query) ? $lang['misc_searchresult'].': <i>'.$query.'</i>' : $lang['admin_listusers'];
		?>
	</h3>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th><?php echo $lang['user_firstname']; ?></th>
					<th><?php echo $lang['user_lastname']; ?></th>
					<th><?php echo $lang['user_lukasid']; ?></th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($user_list as $user)
				{
					echo '<tr class="'.($user->disabled ? 'danger' :'').'"">';
						echo '<td>'.$user->id.'</td>';
						echo '<td>'.$user->first_name.'</td>';
						echo '<td>'.$user->last_name.'</td>';
						echo '<td>'.$user->lukasid.'</td>';
						echo '<td>',
							anchor('admin/user/edit/'.$user->id, $lang['admin_edituser']);
							if($user->new)
								echo ' <span class="label label-warning">'.$lang['user_new'].'</span>';
							if($user->disabled)
								echo ' <span class="label label-danger">'.$lang['user_disabled'].'</span>';
						echo '</td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
	$total_pages = floor($user_count / $user_limit)+1;
	$prev_page = $user_page == 1 ? 1 : $user_page-1;
	$next_page = $user_page == $total_pages ? $total_pages : $user_page+1;
	?>
	<p>
		<ul class="pagination center-block">
			<li<?php echo $user_page == 1 ? ' class="disabled"' : '';?>>
				<?php echo anchor('admin/user/overview/'.$user_method.'/'.$prev_page.'/'.$user_filter, '&laquo;'); ?>
			</li>
			<?php
			for($k = 1; $k <= $total_pages; $k++)
			{
				?>
				<li<?php echo $k == $user_page ? ' class="active"' : '';?>>
					<?php echo anchor('admin/user/overview/'.$user_method.'/'.$k.'/'.$user_filter, $k); ?>
				</li>
				<?php
			}
			?>
			<li<?php echo $user_page == $total_pages ? ' class="disabled"' : '';?>>
				<?php echo anchor('admin/user/overview/'.$user_method.'/'.$next_page.'/'.$user_filter, '&raquo;'); ?>
			</li>
		</ul>
	</p>
</div>
