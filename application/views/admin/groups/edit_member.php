<?php

$member = $members[0];
//do_dump($member);

if($member->user_id == 0)
	redirect('error_page/user/?msg=notfound-adm', 'refresh');

$position = array(
			'id'		=> 'position',
			'name'		=> 'position',
			'value'		=> $member->position,
			'maxlength'	=> '100',
			'class'		=> 'form-control'
		);
$email = array(
			'id'			=> 'email',
			'name'			=> 'email',
			'value'			=> $member->email,
			'maxlength'		=> '100',
			'class'			=> 'form-control',
		);


if($whattodo == 'edit')
{
	if($edit_member)
		echo '<div class="alert alert-success">'.$lang['misc_done'].'</div>';
	else
		echo '<div class="alert alert-danger">'.$lang['error_common'].'</div>';
}


echo form_open('admin/groups/edit_member/'.$groups_year_id.'/'.$group_id.'/'.$member->user_id.'/edit');
?>
<div class="main-box box-body clearfix">
	<h2>
		<?php echo $lang['admin_groups_editmember']; ?>
		<small>
			<em><?php echo get_full_name($member); ?></em>
			<?php echo anchor('admin/groups/list_members/'.$groups_year_id.'/'.$group_id, $lang['misc_back']); ?>
		</small>
	</h2>
	<div class="row">
		<div class="col-sm-4">
			<p>
				<?php echo form_label($lang['admin_groups_position'], 'position'), form_input($position); ?>
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<?php echo form_label('Email', 'email'), form_input($email); ?>
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<?php echo form_label('&nbsp;', 'save'); ?>
				<input type="submit" class="btn btn-success form-control" name="save" id="save" value="<?php echo $lang['misc_save']; ?>">
			</p>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
<div class="main-box box-body clearfix margin-top">
	<h3>
		<?php echo $lang['admin_edituser_drama']; ?>
	</h3>
	<p>
		<?php
			echo anchor('admin/groups/edit_member/'.$groups_year_id.'/'.$group_id.'/'.$member->user_id.'/delete', $lang['admin_groups_deletemember'], 'class="button"');
		?>
	</p>
</div>

