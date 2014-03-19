<?php
if($message == 'success')
	echo '<div class="alert alert-success">'.$lang['misc_done'].'</div>';

if($message == 'error')
	echo '<div class="alert alert-danger">'.$lang['error_error'].'</div>';
?>

<div class="main-box box-body clearfix">
	<h2><?php echo $lang['admin_addgroup']; ?></h2>
	<p><?php echo anchor('admin/groups/create', $lang['admin_createnewgroupbyclicking']); ?></p>
</div>

<div class="main-box box-body clearfix margin-top">
	<h4><?php echo $lang['admin_groups_official']; ?></h4>

	<ul class="box-list list-unstyled">
		<?php
		foreach ($groups_array as $group) {
			echo '<li>';
			echo anchor(
					'admin/groups/edit/'.$group->id,
					$group->name.($group->official ? '' : '<span class="label label-info">'.$lang['misc_unofficial'].'</span>'),
					array("title" => $lang['admin_editgroup'])
				);
			echo '</li>';
		}
		?>
	</ul>
</div>
