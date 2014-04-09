<?php
echo '
<div class="main-box box-body clearfix">
<h2>Dokumentarkiv för ' . $group . '</h2>
<ul class = "list-unstyled document-list clearfix">';

$protocols = array_slice($document_types, 0, 1);
$document_types = array_slice($document_types, 1);

foreach($protocols as $protocols_docs)
{
	// Select year
	$form_options = array();

	$uri = explode('/', uri_string());
	
	if(sizeof($uri) == 4) 		//association/documents/xxxx
		$dropdown_uri = '';
	else if(sizeof($uri) == 3) 		//association/documents/
		$dropdown_uri = 'documents/';
	else if(sizeof($uri) == 2)
		$dropdown_uri = 'association/documents/';

	echo
	'<h3 class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle">'.$lang['document_protocol'].' <b class="caret"></b></a>
        <ul class="dropdown-menu">';
			foreach($document_years_array as $year)
			{
				$dropdown_link = $dropdown_uri.$year;
				$dropdown_name = $year."/".($year + 1);
				echo '<li class="list-unstyled"><a href="'.$dropdown_link.'">'.$dropdown_name.'</a></li>';
			}
    echo
    	'</ul>
    </h3>';

	// Show documents of selected year
	foreach ($protocols_docs->documents as $doc) {
		$doc_date = strtotime($doc->upload_date);
		$doc_year = date('Y', $doc_date);
		$doc_month = date('m', $doc_date);

		if($doc_month < 6)
			$doc_year--;

		if($doc_year == $protocol_year)
		{
			$upload_date = substr($doc->upload_date, 0, 10);
			echo
			'<li class = "document clearfix">
			<a href="' . base_url() . '/user_content/documents/'.$upload_date.'/'.$doc->document_original_filename .'">	
				<i class = "-icon-document"></i>
				<h4>'. $doc->document_title . '</h4>
				<small>' . date("d M, Y", strtotime($doc->upload_date)) . '</small>
			</a>
			</li>';
		}
	}
}

//List documents
foreach ($document_types as $type) {
	echo '<h3>'.$lang['document_'.$type->document_type].'</h3>';
	foreach ($type->documents as $doc) {
		$upload_date = substr($doc->upload_date, 0, 10);
		echo
		'<li class = "document clearfix">
		<a href="' . base_url() . '/user_content/documents/'.$upload_date.'/'. $doc->document_original_filename .'">	
			<i class = "-icon-document"></i>
			<h4>'. $doc->document_title . '</h4>
			<small>' . date("d M, Y", strtotime($doc->upload_date)) . '</small>
		</a>
		</li>';
	}
}
echo '</ul>';
echo '</div>';