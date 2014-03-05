<?php

$lukasid = array(
              'id'          => 'lukasid',
              'name'        => 'lukasid',
              'maxlength'   => '100',
              'class'        => 'form-control',
            );
$firstname = array(
              'id'          => 'firstname',
              'name'        => 'firstname',
              'maxlength'   => '100',
              'class'        => 'form-control',
            );
$lastname = array(
              'id'          => 'lastname',
              'name'        => 'lastname',
              'maxlength'   => '100',
              'class'        => 'form-control',
            );

if(isset($status))
{
	if($status)
	{
		echo '<div class="alert alert-success">'.$lang['admin_addusers_success'].' '.anchor('admin/user/edit/'.$entered['lid'], $lang['admin_edituser']).'</div>';
	}
	else{
		echo $status;
		echo '<div class="alert alert-danger"><strong>'.$lang['admin_addusers_error'].'</strong> ',
			$errormsg,
		'</div>';

		$lastname['value'] = $entered['lname'];
		$lukasid['value'] = $entered['lid'];
		$password['value'] = $entered['pwd'];
		$firstname['value'] = $entered['fname'];
	}

}

?>

<?php echo form_open('admin/user/add/create'); ?>
<div class="main-box clearfix profile">
	<h3>
		<?php echo $lang['admin_addusers']; ?>
	</h3>
	<div class="row">
		<div class="col-sm-4">
			<p>
				<input type="submit" value="<?php echo $lang['misc_save']; ?>" id="save" name="save" class="btn btn-success form-control" />
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<p>
				<?php
				echo form_label($lang['user_firstname'], 'firstname'), form_input($firstname);
				?>
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<?php
				echo form_label($lang['user_lastname'], 'lastname'), form_input($lastname);
				?>
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<?php
				echo  form_label($lang['user_lukasid'], 'lukasid'), form_input($lukasid);
				?>
			</p>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
