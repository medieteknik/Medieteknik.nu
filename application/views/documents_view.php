<?php
echo '
<div class="main-box clearfix">
<h2>Dokumentarkiv för ' . $group . '</h2>';

//do_dump($document_types);

//List documents
echo '<ul class = "document-list clearfix">';
foreach ($document_types as $type) {
	echo '<h3>'.$lang['document_'.$type->document_type].'</h3>';
	foreach ($type->documents as $doc) {
		echo
		'<li class = "document clearfix">
		<a href="' . base_url() . '/user_content/documents/'. $doc->document_original_filename .'">	
			<i class = "-icon-document"></i>
			<h4>'. $doc->document_title . '</h4>
			<small>' . date("d M, Y", strtotime($doc->upload_date)) . '</small>
		</a>
		</li>';
	}
}
echo '</ul>';
echo '</div>';