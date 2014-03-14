<?php

if($user->id == 0)
	show_404();

$lukasid = array(
			'id'		=> 'lukasid',
			'name'		=> 'lukasid',
			'value'		=> $user->lukasid,
			'maxlength'	=> '100',
			'class' 	=> 'form-control'
		);
$firstname = array(
			'id'		=> 'firstname',
			'name'		=> 'firstname',
			'value'		=> $user->first_name,
			'maxlength'	=> '100',
			'class' 	=> 'form-control'
		);
$lastname = array(
			'id'		=> 'lastname',
			'name'		=> 'lastname',
			'value'		=> $user->last_name,
			'maxlength'	=> '100',
			'class' 	=> 'form-control'
		);
$twitter = array(
			'id'		=> 'twitter',
			'name'		=> 'twitter',
			'value'		=> $user->twitter,
			'maxlength'	=> '15',
			'class' 	=> 'form-control'
		);
$linkedin = array(
			'id'			=> 'linkedin',
			'name'			=> 'linkedin',
			'value'			=> $user->linkedin,
			'maxlength'		=> '100',
			'class' 		=> 'form-control',
			'placeholder'	=> 'http://linkedin.com/in/...'
		);
$web = array(
			'id'			=> 'web',
			'name'			=> 'web',
			'value'			=> $user->web,
			'maxlength'		=> '100',
			'class' 		=> 'form-control',
			'placeholder'	=> 'http://'
		);
$gravatar = array(
			'id'			=> 'gravatar',
			'name'			=> 'gravatar',
			'value'			=> $user->gravatar,
			'maxlength'		=> '100',
			'class' 		=> 'form-control'
		);
$presentation = array(
			'id'		=> 'presentation',
			'name'		=> 'presentation',
			'value'		=> $user->presentation,
			'rows'		=> '4',
			'class' 	=> 'form-control'
		);


if(!empty($message))
{
	echo '<div class="alert alert-success">'.$lang['misc_done'].'</div>';
}
?>

<?php echo form_open('admin/user/edit/'.$user->id.'/edit'); ?>
<div class="main-box clearfix profile">
	<h3>
		<?php
		echo $lang['admin_edituser'].' <em>'.get_full_name($user).'</em> <small>',
			anchor('#', $lang['misc_back'], array('onclick' => 'window.history.back(); return false;')).'</small>'; ?>
	</h3>
	<div class="row">
		<div class="col-sm-4">
			<p>
				<?php echo form_label('&nbsp;', 'save'); ?>
				<input type="submit" value="<?php echo $lang['misc_save']; ?>" id="save" name="save" class="btn btn-success form-control" />
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<?php
				echo form_label('&nbsp;', 'disable');
				if($user->disabled)
					echo '<input type="submit" value="'.$lang['admin_edituser_activate'].'" id="disable" name="disable" class="btn btn-info form-control" />';
				else
					echo '<input type="submit" value="'.$lang['admin_edituser_deactivate'].'" id="disable" name="disable" class="btn btn-danger form-control" />';
				?>
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<?php
				if($user->new)
				{
					echo form_label($lang['admin_edituser_approve_wat'], 'activate');
					echo '<input type="submit" value="'.$lang['admin_edituser_approve'].'" id="activate" name="activate" class="btn btn-info form-control" />';
				}
				?>
			</p>
		</div>
	</div>
</div>
<div class="main-box clearfix margin-top">
	<h4><?php echo $lang['user_info']; ?></h4>
	<div class="row">
		<div class="col-sm-6">
			<p>
				<?php
				echo form_label($lang['user_firstname'], 'firstname'), form_input($firstname);
				?>
			</p>
			<p>
				<?php
				echo form_label($lang['user_lastname'], 'lastname'), form_input($lastname);
				?>
			</p>
			<p>
				<?php
				echo form_label($lang['user_lukasid'], 'lukasid'), form_input($lukasid);
				?>
			</p>
			<p>
				<?php
				echo form_label('Gravatar', 'gravatar'), form_input($gravatar);
				?>
			</p>
		</div>
		<div class="col-sm-6">
			<p>
				<?php
				echo form_label('Twitter', 'twitter'), form_input($twitter);
				?>
			</p>
			<p>
				<?php
				echo form_label('LinkedIn', 'linkedin'), form_input($linkedin);
				?>
			</p>
			<p>
				<?php
				echo form_label('Web', 'web'), form_input($web);
				?>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<p>
				<?php
				echo  form_label('Presentation', 'presentation'), form_textarea($presentation);
				?>
			</p>
		</div>
	</div>
</div>

<div class="main-box clearfix margin-top">
	<h4>Admin privileges</h4>
	<div class="row">
		<div class="col-sm-6">
			<p>
				<label for="admin_privil">Privil level</label>
				<select name="admin_privil" id="admin_privil" class="form-control">
					<option value="0">None</option>
					<?php
					$user_level = count($user_privil) > 0 ? $user_privil[0]->privilege_id : '0';
					foreach ($privil as $priv)
					{
						echo '<option value="'.$priv->id.'" '.($user_level == $priv->id ? 'selected' : '').'>'.$priv->privilege_name.' &ndash; '.$priv->privilege_description.'</option>';
					}
					?>
				</select>
			</p>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
