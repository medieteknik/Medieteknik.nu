<?php
echo '
<div class="main-box clearfix">
<h2>Dokumentarkiv för ' . $group . '</h2>';

echo '<ul class = "document-list clearfix">';
foreach ($documents as $doc) {
	echo
	'<li class = "document clearfix">
	<a href="' . base_url() . '/user_content/documents/'. $doc->document_original_filename .'">	
		<i class = "-icon-document"></i>
		<h4>'. $doc->document_original_filename . '</h4>
		<small>' . date("d M, Y", strtotime($doc->upload_date)) . '</small>
	</a>
	</li>';
}
echo '</ul>';
echo '</div>';