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
$photo = array(
		            	'name'        => 'photo',
		            	'id'          => 'photo',
		            	'class' 	  => 'form-control'
     				 );
$link = array(
		            	'name'        => 'link',
		            	'id'          => 'link',
		            	'class' 	  => 'form-control',
		            	'placeholder'	=> 'http://...',
     				 );

$carousel_disabled = 0;
$carousel_draft = 0;


// hack so that the same view can be used for both create and edit
$action = 'admin/carousel/edit_carousel/0';
if(isset($carousel) && $carousel != false) {
	$disabled['checked'] = ($carousel->disabled == 1);
	$draft['checked'] = ($carousel->draft == 1);
	$carousel_disabled = $carousel->disabled;
	$carousel_draft = $carousel->draft;
	$action = 'admin/carousel/edit_carousel/'.$id;
}

$action_image = 'admin/carousel/add_image/0';
if(isset($carousel) && $carousel != false) {
	$action_image = 'admin/carousel/add_image/'.$id;
}

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
              'class'		=> 'form-control',
              'value'       => $t_title,
            );
	$content = array(
              'name'        => 'content_'.$language_abbr,
              'id'          => 'content_'.$language_abbr,
              'rows'		=>	3,
	          'class' 		=> 'form-control'
            );

	echo '
	<div class="col-sm-6">
		<div class="main-box box-body clearfix margin-top">
			<h4>',$language_name,' <img src="'.lang_id_to_imgpath($lang_id).'" class="img-circle" /></h4>',
			'<p>',
				form_label($lang['misc_headline'], 'title_'.$language_abbr),'<br />',
				form_input($title),'<br />',
			'</p>',
			'<p>',
				form_label($lang['misc_text'], 'content_'.$language_abbr),'<br />',
				form_textarea($content,$t_content),'<br />',
			'</p>',
		'</div>
	</div>';
}
echo '</div>';
echo form_close();

// Carousel must exist before you can add images
if(isset($carousel) && $carousel != false) {

	$grayscale = array(	'name'        => 'grayscale',
						'id'          => 'grayscale',
						'value'       => '1',
						'checked'     => FALSE,
					);
	$blurred = array(	'name'        => 'blurred',
						'id'          => 'blurred',
						'value'       => '1',
						'checked'     => FALSE,
					);

	echo '<div class="main-box box-body clearfix margin-top">';
		echo '<div class="row">';
			// Images
			echo '<div class="col-sm-12">';
			echo '<h2>'.$lang['misc_images'].'</h2>';
				// Show images
				if(isset($carousel) && $carousel != false)
				{
					if (count($images_array) > 0) {
						foreach($images_array as $img) {
							if($img->image_original_filename != "") {
								$image = new imagemanip($img->image_original_filename, 'zoom', 160, 160);
								echo '<div class="col-xs-3">',
								'<img src="'.$image.'" class="thumbnail centered"/>'.'<br />',
									'<div class="centered">',
									anchor('admin/carousel/remove_image/'.$id.'/'.$img->images_id, $lang['admin_removeimage'], array('class' => 'btn btn-danger')),
									'</div>',
								'</div>';
							}
						}
					}
				}
			
			echo '</div>';
			echo '</div>';
			echo '<div class="row">';
			echo '<div class="col-sm-12">';
				// Open form to upload new image
				echo form_open_multipart($action_image, 'add_image');
				
				echo '<h3>'.$lang['admin_addimage'].'</h3>';
				echo '<p>'.form_upload($img_file).'</p>';
				echo '<h4>Filter</h4>',
				'<label class="checkbox-inline">',
					form_checkbox($blurred),' ',form_label($lang['misc_image_blurred'], 'blurred'),
				'</label>',
				'<label class="checkbox-inline">',
					form_checkbox($grayscale),' ',form_label($lang['misc_image_grayscale'], 'grayscale'),
				'</label>';
				echo '<h4>'.$lang['misc_copyright'].'</h4>';

			echo '</div>';
			echo '<div class="col-sm-6">',
				'<p>',
					form_label($lang['misc_photo'], 'photo'),
					form_input($photo),
				'</p>';
			echo '</div>';
			echo '<div class="col-sm-6">',
				'<p>',
					form_label($lang['misc_link'], 'link'),
					form_input($link),
				'</p>';
			echo '</div>';
			echo '<div class="col-sm-12">';
				//echo form_submit('add_image', $lang['misc_upload']);
				echo '<p><input type="submit" name="add_image" id="save" value="',$lang['misc_upload'],'" class="btn btn-success" /></p>';
				echo form_close();
			echo '</div>';	
		echo '</div>';	
	echo '</div>';
}
