<?php

// prepare all the data
$title = array(		'name'        => 'title',
						'id'          => 'title',
						'value'       => ''
					);
$description = array(			'name'        	=> 'description',
						'id'          => 'description',
						'value'       => ''
					);

$img_file = array(		'name'        => 'img_file',
						'id'          => 'img_file',
					);


// do all the printing
$action = 'admin_images/upload';
echo 
form_open_multipart($action),
'<div class="main-box clearfix">
	<h2>', $lang['admin_addimage'], '</h2>',
	form_label($lang['misc_title'], 'title'),
	form_input($title),

	form_label($lang['misc_description'], 'description'),
	form_input($description),
	'<div>',
		form_upload($img_file),
	'</div>',
	'<div>', form_submit('save', $lang['misc_save']), '</div>
</div>';

echo form_close();
