<?php
echo '
<div class="main-box clearfix">
<h2>Dokumentarkiv för ' . $group . '</h2>
<ul class = "document-list clearfix">';

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

	foreach($document_years_array as $year)
	{
		$dropdown_value = $dropdown_uri.$year;
		$form_options[$dropdown_value] = "Protokoll ".$year."/".($year + 1);
	}

	// drop down will work as link
	$js = "class='document' onchange='location = this.options[this.selectedIndex].value;'";
	echo '<h3>'.form_dropdown('protocol_year', $form_options, $protocol_year, $js).'</h3>';

	// Show documents of selected year
	foreach ($protocols_docs->documents as $doc) {
		$doc_date = strtotime($doc->upload_date);
		$doc_year = date('Y', $doc_date);
		$doc_month = date('m', $doc_date);

		if($doc_month < 6)
			$doc_year--;

		if($doc_year == $protocol_year)
		{
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
}

//List documents
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