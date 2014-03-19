<?php

// prepare all the data
$draft = array(
				'name'        => 'draft',
				'id'          => 'draft',
				'value'       => '1',
				'checked'     => TRUE,
			);
$pagename = array(
				'name'        => 'pagename',
				'id'          => 'pagename',
				'class'		  => 'form-control',
				'placeholder' => '...'
			);

// hack so that the same view can be used for both create and edit
$action = 'admin/page/edit_page/0';
if(isset($page) && $page != false) {
	$draft['checked'] = ($page->published == 0);
	$action = 'admin/page/edit_page/'.$id;
	$pagename['value'] = $page->name;
}

if(isset($message) && $message == 'success')
	echo '<div class="alert alert-success">'.$lang['misc_done'].'</div>';
elseif(isset($message) && $message == 'error')
	echo '<div class="alert alert-danger">'.$lang['admin_error_remove'].'</div>';

// do all the printing
echo form_open($action);
?>
<div class="main-box box-body clearfix">
	<h2><?php echo $lang['admin_editpage']; ?> <small><?php echo anchor('admin/page', $lang['misc_back']); ?></small></h2>
	<div class="row">
		<div class="col-sm-4">
			<p>
				<?php echo form_label($lang['misc_title'],'pagename'),form_input($pagename); ?>
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<label>
					<?php echo form_checkbox($draft),' ',$lang['misc_draft']; ?>
				</label>
				<input type="submit" name="save" id="save" value="<?php echo $lang['misc_save']; ?>" class="btn btn-success form-control">
			</p>
		</div>
		<div class="col-sm-4">
			<p>
				<?php echo form_label($lang['admin_news_delete'], 'delete'); ?>
				<input type="submit" name="delete" id="delete" value="<?php echo $lang['misc_delete']; ?>" class="btn btn-danger form-control">
			</p>
		</div>
	</div>
</div>

<?php
// hack so that the same view can be used for both create and edit
$arr = '';
if(isset($page) && $page != false) {
	$arr = $page->translations;
} else {
	$arr = $languages;
}

echo '<div class="row">';

	foreach($arr as $t) {
		// hack so that the same view can be used for both create and edit
		if(isset($page) && $page != false)
		{
			$t_title = $t->header;
			$t_text = $t->content;
			$language_abbr = $t->language_abbr;
			$language_name = $t->language_name;
			$lang_id = $t->lang_id;
		}
		else
		{
			$t_title = '';
			$t_text = '';
			$language_abbr = $t['language_abbr'];
			$language_name = $t['language_name'];
			$lang_id = $t['id'];
		}

		$title = array(
	              'name'        => 'title_'.$language_abbr,
	              'id'          => 'title_'.$language_abbr,
	              'value'       => $t_title,
	              'class'		=> 'form-control'
	            );
		$text = array(
	              'name'        => 'text_'.$language_abbr,
	              'id'          => 'text_'.$language_abbr,
	              'rows'		=>	30,
	              'class'		=> 'form-control'
	            );

		echo '
		<div class="col-sm-6">
			<div class="main-box box-body clearfix margin-top">
				<h4>',$language_name,' <img src="'.lang_id_to_imgpath($lang_id).'" class="img-circle" /></h4>',
				'<p>',
					form_label($lang['misc_headline'], 'title_'.$language_abbr),
					form_input($title),
				'</p>',
				'<p>',
					form_label($lang['misc_text'], 'text_'.$language_abbr),
					form_textarea($text,$t_text),
				'</p>
			</div>
		</div>';
	}
echo '</div>';
echo form_close();
