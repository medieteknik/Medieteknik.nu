<?php
//do_dump($group);

// prepare all the data
$official = array(		'name'        => 'official',
						'id'          => 'official',
						'value'       => '1',
						'checked'     => TRUE,
					);

// hack so that the same view can be used for both create and edit
$action = 'admin/groups/edit_group/0';
if(isset($group) && $group != false) {
	$official['checked'] = ($group->official == 1);
	$action = 'admin/groups/edit_group/'.$id;
}

// do all the printing
echo form_open($action);
?>
<div class="main-box box-body clearfix">
	<h3><?php echo isset($id) ? $lang['admin_editgroup'] : $lang['admin_addgroup']; ?> <small><?php echo anchor('admin/groups', $lang['misc_back']); ?></small></h3>
	<div class="row">
		<div class="col-sm-4">
			<p>
				<input type="submit" name="save" id="save" class="form-control btn btn-success" value="<?php echo $lang['misc_save']; ?>" />
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<label>
					<?php
					echo form_checkbox($official).' '.$lang['misc_official'];
					?>
				</label>
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<?php
				if(isset($id))
					echo '<input type="submit" name="delete" id="delete" class="form-control btn btn-danger" value="'.$lang['misc_delete'].'" />';
				?>
			</p>
		</div>
	</div>
</div>

<div class="main-box box-body clearfix margin-top">
	<h3><?php echo $lang['misc_translations']; ?></h3>
	<div class="row">
		<?php
		// hack so that the same view can be used for both create and edit
		//do_dump($page);
		$arr = '';
		if(isset($group) && $group != false) {
			$arr = $group->translations;
		} else {
			$arr = $languages;
		}

		// loop throuch translations
		foreach ($arr as $t) {

			// hack so that the same view can be used for both create and edit
			if(isset($group) && $group != false)
			{
				$t_name = $t->name;
				$t_description = $t->description;
				$language_abbr = $t->language_abbr;
				$language_name = $t->language_name;
			}
			else
			{
				$t_name = '';
				$t_description = '';
				$language_abbr = $t['language_abbr'];
				$language_name = $t['language_name'];
			}

			// prep inputs
			$name = array(
		              'name'        => 'name_'.$language_abbr,
		              'id'          => 'name_'.$language_abbr,
		              'value'       => $t_name,
		              'class'		=> 'form-control',
		              'placeholder' => $lang['misc_headline']
		            );
			$description = array(
		              'name'        => 'description_'.$language_abbr,
		              'id'          => 'description_'.$language_abbr,
		              'rows'		=>	10,
		              'class'		=> 'form-control',
		              'placeholder' => $lang['misc_text'].'...'
		            );

			// display translation input areas
			?>
			<div class="col-sm-6">
				<h4><?php echo $language_name; ?></h4>
				<p>
					<?php
					echo form_label($lang['misc_headline'], 'title_'.$language_abbr), form_input($name);
					?>
				</p>
				<p>
					<?php
					echo form_label($lang['misc_text'], 'text_'.$language_abbr), form_textarea($description,$t_description)
					?>
				</p>
			</div>
			<?php
		}
		?>
	</div>
</div>
<?php echo form_close(); ?>

<div class="main-box box-body clearfix margin-top">
	<?php
	if (isset($id) && $id)
	{
		echo '<h3>',
			$lang['admin_groups_editmembers'],' <small>',
			anchor('admin/groups/add_year/'.$id, $lang['admin_createnewgroupbyclicking']),'</small>',
		'</h3>';
		echo '<ul class="list-unstyled box-list">';
		foreach ($group_years as $group_year)
		{
			echo '<li>';
			$link = ($group_year->start_year == $group_year->start_year ? $group_year->start_year : $group_year->start_year.'/'.$group_year->stop_year).' ';

			foreach ($group_year->members as $member)
			{
				$extra = 'class="img-circle" data-toggle="tooltip"';
				$extra .= ' title="'.get_full_name($member).' –  '.$member->position.'"';
				$link .= gravatarimg($member, 20, $extra);
			}
			echo anchor("admin/groups/list_members/".$group_year->id.'/'.$id, $link);
			echo '</li>';
		}
		echo '</ul>';
	}
	?>
</div>
<?php
// do_dump($group);
// do_dump($group_years);
