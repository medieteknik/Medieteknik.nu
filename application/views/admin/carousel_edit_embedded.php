<?php

// prepare all the data
$img_file = array(		'name'        => 'img_file',
						'id'          => 'img_file',
					);
$disabled = array(		'name'        => 'disabled',
						'id'          => 'disabled',
						'value'       => '1',
						'checked'     => FALSE,
					);
$draft = array(			'name'        => 'draft',
						'id'          => 'draft',
						'value'       => '1',
						'checked'     => FALSE,
					);

$carousel_disabled = 0;
$carousel_draft = 0;
$carousel_url = '';

// hack so that the same view can be used for both create and edit
$action = 'admin/carousel/edit_carousel/0';
if(isset($carousel) && $carousel != false) {
	$disabled['checked'] = ($carousel->disabled == 1);
	$draft['checked'] = ($carousel->draft == 1);
	$carousel_disabled = $carousel->disabled;
	$carousel_draft = $carousel->draft;
	$carousel_url = $carousel->translations[0]->content;
	$action = 'admin/carousel/edit_carousel/'.$id;
}

$url = array(
		            	'name'        => 'content_',
		            	'id'          => 'content_',
		            	'value' 	  => $carousel_url,
		            	'class' 	  => 'form-control',
		            	'placeholder' => 'http://...'
     				 );

// do all the printing
echo
form_open($action, 'save'),
'<div class="main-box box-body clearfix">
	<h2>', $lang['admin_admincarousel'], '</h2>',
	'<div class="row">',
		'<div class="col-sm-4">',
			'<label class="checkbox-inline">',
				form_checkbox($disabled),' ',form_label($lang['misc_disabled'], 'disabled'),
			'</label>',
			'<label class="checkbox-inline">',
				form_checkbox($draft),' ',form_label($lang['misc_draft'], 'draft'),
			'</label>',
			form_hidden('item_type', 2),
			'<p><input type="submit" name="save" id="save" value="',$lang['misc_save'],'" class="btn btn-success form-control" /></p>',
		'</div>';
		if(isset($carousel) && $carousel != false)
		{
			echo '<div class="col-sm-4 pull-right">',
				'<p>',
					form_label($lang['misc_delete'], 'delete'),
					anchor('admin/carousel/delete/'.$id,
						'<span class=\'glyphicon glyphicon-trash\'></span> '.$lang['misc_delete'],
						array('class' => 'btn btn-danger form-control')
						),
				'</p>',
			'</div>';
		}
	echo '</div>',
'</div>';

echo '<div class="main-box box-body clearfix margin-top">',
		'<div class="row">',
	 		'<div class="col-sm-12">',
	 			'<h4>',
					form_label('URL', 'content_'),'<br />',
				'</h4>',
				'<p>',
						form_input($url),'<br />',
				'</p>',
			'</div>',
		'</div>',
	'</div>';


// hack so that the same view can be used for both create and edit
$arr = '';
if(isset($carousel) && $carousel != false) {
	$arr = $carousel->translations;
} else {
	$arr = $languages;
}

echo '<div class="row">';
foreach($arr as $t) {
	// hack so that the same view can be used for both create and edit
	if(isset($carousel) && $carousel != false) {
		$t_title = $t->title;
		$t_content = $t->content;
		$language_abbr = $t->language_abbr;
		$language_name = $t->language_name;
		$lang_id = $t->lang_id;

	} else {
		$t_title = '';
		$t_content = '';
		$language_abbr = $t['language_abbr'];
		$language_name = $t['language_name'];
		$lang_id = $t['id'];
	}

	$title = array(
              'name'        => 'title_'.$language_abbr,
              'id'          => 'title_'.$language_abbr,
              'class' 	  => 'form-control',
              'value'       => $t_title,
            );

	echo '
	<div class="col-sm-6">
		<div class="main-box box-body clearfix margin-top">
			<h4>',$language_name,' <img src="'.lang_id_to_imgpath($lang_id).'" class="img-circle" /></h4>',
			'<p>',
				form_label($lang['misc_headline'], 'title_'.$language_abbr),'<br />',
				form_input($title),'<br />',
			'</p>',
		'</div>
	</div>';
}
echo form_close();
echo '</div>';