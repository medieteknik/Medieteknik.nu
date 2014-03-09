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
              							'type' 		=> 'search'
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
<?php
echo isset($list_users) ? $list_users : '';
?>
