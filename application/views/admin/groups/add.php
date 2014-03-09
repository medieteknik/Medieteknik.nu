<?php

$startyear = array(
              'id'          => 'startyear',
              'name'        => 'startyear',
              'class'       => 'form-control',
              'placeholder' => 'YYYY',
              'type'		=> 'number',
              'min'			=> 1997,
              'max'			=> date('Y')+3,
              'value' 		=> (isset($entered['start']) ? $entered['start'] : '')
            );
$stopyear = array(
              'id'          => 'stopyear',
              'name'        => 'stopyear',
              'class'       => 'form-control',
              'placeholder' => 'YYYY',
              'type'		=> 'number',
              'min'			=> 1997,
              'max'			=> date('Y')+3,
              'value' 		=> (isset($entered['stop']) ? $entered['stop'] : '')
            );

if(isset($status) && !$status)
{
	echo '<div class="alert alert-danger">'.$lang['admin_groups_year_error'].'</div>';
}

echo form_open('admin/groups/add_year/'.$group_id.'/create');
?>
<div class="main-box clearfix">
	<h3>
		<?php echo $lang['admin_groups_add_year']; ?>
	</h3>
	<div class="row">
		<div class="col-sm-4">
			<p>
				<?php echo form_label($lang['admin_groups_startyear'], 'startyear'), form_input($startyear); ?>
			</p>
			<p>
				<?php echo form_label($lang['admin_groups_stopyear'], 'stopyear'), form_input($stopyear); ?>
			</p>
			<p>
				<input type="submit" value="<?php echo $lang['misc_save']; ?>" class="form-control btn btn-success" name="save" id="save">
			</p>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
