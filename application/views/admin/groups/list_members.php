<?php
echo isset($_GET['confdel']) ? '<div class="alert alert-success">'.$lang['misc_done'].'</div>' : '';
?>
<div class="main-box box-body clearfix">
	<h2>
		<?php
		echo $lang['admin_groups_editmembers'];
		echo ' <small>',
			($group_year->start_year == $group_year->stop_year ? $group_year->start_year : $group_year->start_year.'/'.$group_year->stop_year),' ',
			anchor('admin/groups/edit/'.$group_id, $lang['misc_back']),
		'</small>';
		?>
	</h2>
	<p>
		<?php echo anchor('admin/groups/add_member/'.$groups_year_id.'/'.$group_id, $lang['admin_addmemberbyclicking']); ?>
	</p>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th><?php echo $lang['user_name']; ?></th>
					<th><?php echo $lang['admin_groups_position']; ?></th>
					<th>Email</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($member_list as $member)
				{
					$gravatar = gravatarimg($member, 20, 'class="img-circle"');
					echo '<tr>';
						echo '<td>'.anchor("user/profile/".$member->user_id, $gravatar.' '.get_full_name($member)).'</td>';
						echo '<td>'.$member->position.'</td>';
						echo '<td>'.$member->email.'</td>';
						echo '<td>',
							anchor('admin/groups/edit_member/'.$groups_year_id.'/'.$group_id.'/'.$member->user_id, $lang['admin_groups_editmember']);
						echo '</td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
if(isset($groups_year_id))
{
?>
	<div class="main-box box-body clearfix margin-top">
		<h2><?php echo $lang['misc_delete']; ?></h2>
		<?php echo form_open('admin/groups/remove_year/'.$groups_year_id); ?>
			<p>
				<input type="submit" id="delete" name="delete" value="<?php echo $lang['misc_delete']; ?>" class="btn btn-danger">
			</p>
		<?php echo form_close(); ?>
	</div>
<?php
}
?>
