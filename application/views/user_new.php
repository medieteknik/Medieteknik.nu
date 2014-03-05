<?php
// prepare input form
$firstname = array(
				'id'		=> 'firstname',
				'name'		=> 'firstname',
				'maxlength'	=> '100',
				'class'		=> 'form-control',
				'placeholder' => $lang['user_firstname'],
				'required'	=> ''
			);
$lastname = array(
				'id'		=> 'lastname',
				'name'		=> 'lastname',
				'maxlength'	=> '100',
				'class'		=> 'form-control',
				'placeholder' => $lang['user_lastname'],
				'required'	=> ''
			);


if(isset($error))
{
	echo '<div class="main-box clearfix"><p class="notice red">'.$lang['error_common'].'</p></div>';
}

echo form_open('user/new_user/'.$redir_arr[0].'/'.$redir_arr[1]);
?>

<div class="main-box clearfix profile">
	<h2>Nytt konto: <i><?php echo $user; ?></i></h2>
	<div class="row">
		<div class="col-sm-8">
			<?php echo $lang['user_create_wat']; ?>
		</div>
		<div class="col-sm-4">
			<p>
				<?php echo form_label($lang['user_firstname'], 'firstname'), form_input($firstname); ?>
			</p>
			<p>
				<?php echo form_label($lang['user_lastname'], 'lastname'), form_input($lastname); ?>
			</p>
			<p>
				<input type="submit" name="save" id="save" class="form-control btn btn-success" value="<?php echo $lang['user_create_save']; ?>" />
			</p>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
