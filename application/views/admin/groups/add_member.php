<?php
$search = array(
              'id'          => 'search',
              'name'        => 'search',
              'value'		=> (isset($query) ? $query : ''),
              'placeholder'	=> $lang['misc_typeandenter'],
              'maxlength'   => '100',
              'size'        => '50',
              'class' 		=> 'form-control'
            );


if(isset($status))
{
	if($status)
	{
		echo '<div class="alert alert-success">'.$lang['admin_addusers_success'].' '.anchor('admin/groups/edit_member/'.$groups_year_id.'/'.$group_id.'/'.$user_added, $lang['admin_edituser']).'</div>';
	}
	else
	{
		echo '<div class="alert alert-danger"><strong>'.$lang['admin_addusers_error'].'</strong></div>';
	}
}

echo form_open('admin/groups/add_member/'.$groups_year_id.'/'.$group_id.'/search', array('method' => 'get'));
?>
<div class="main-box clearfix">
	<h2>
		<?php
		echo $lang['admin_searchusers'];
		echo ' <small>'.anchor('admin/groups/list_members/'.$groups_year_id.'/'.$group_id, '&larr; '.$lang['misc_back']).'</small>';
		?>
	</h2>
	<p>
		<?php echo form_input($search); ?>
	</p>
</div><!-- close .main-box -->
<?php
echo form_close();

if(isset($result) && is_array($result))
{
	?>
	<div class="main-box clearfix margin-top">
		<h2><?php echo $lang['misc_searchresult'].' <em>'.$query.'</em> ('.sizeof($result).' '.$lang['misc_searchhits'].')'; ?></h2>

		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><?php echo $lang['user_name']; ?></th>
						<th><?php echo $lang['user_lukasid']; ?></th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($result as $user)
				{
					echo '<tr class="'.($user->disabled ? 'danger' :'').'"">';
						echo '<td>'.get_full_name($user);
							if($user->disabled)
								echo ' <span class="label label-danger">'.$lang['user_disabled'].'</span>';
						echo '</td>';
						echo '<td>'.$user->lukasid.'</td>';
						echo '<td>';
						echo anchor('admin/groups/add_member/'.$groups_year_id.'/'.$group_id.'/add/'.$user->id, $lang['admin_addasmember']);
						echo '</td>';
					echo '</tr>';
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
}
