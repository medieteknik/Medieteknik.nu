
<div class="main-box clearfix">
	<!-- Dropzone setup -->
	<script type="text/javascript">
		// AcceptedFiles and maxFilesize are set in documents_model
		var ACCEPTEDFILES = '<?php echo $config['acceptedFiles']; ?>',
			MAXFILESIZE = '<?php echo $config['maxSize']; ?>';


		var now = new Date();
		var day = ("0" + now.getDate()).slice(-2),
			month = ("0" + (now.getMonth() + 1)).slice(-2),
			today = now.getFullYear()+"-"+(month)+"-"+(day) ;

		var PREVIEW = ''+
			'<div class="dz-preview">'+
				'<h4><span data-dz-name></span> <em data-dz-size></em></h4>'+
				'<div class="row">'+
					'<div class="col-sm-3">'+
						'<label><?php echo $lang['document_type']; ?></label>'+
						'<select id="type" class="form-control" name="document_type">'+
							'<option value="1"><?php echo $lang['document_protocol'].' - '.$lang['document_protocol_normal']?></option>'+
							'<option value="1_autumn"><?php echo $lang['document_protocol'].' - '.$lang['document_documents_meeting_autumn']?></option>'+
							'<option value="1_spring"><?php echo $lang['document_protocol'].' - '.$lang['document_documents_meeting_spring']?></option>'+
							'<option value="3"><?php echo $lang['document_documents_meeting_autumn']?></option>'+
							'<option value="4"><?php echo $lang['document_documents_meeting_spring']?></option>'+
							'<option value="2"><?php echo $lang['document_directional_document']?></option>'+
						'</select>'+
					'</div>'+
					'<div class="col-sm-3">'+
						'<label><?php echo $lang['misc_title']; ?></label>'+
						'<input id="title" type="text" class="form-control" name="title" value="Styrelsemöte" disabled/>'+
					'</div>'+
					'<div class="col-sm-3">'+
						'<label><?php echo $lang['misc_description']; ?></label>'+
						'<input id="description" class="form-control" type="text" name="description" value="Protokoll från styrelsemötet '+today+'" disabled/>'+
					'</div>'+
					'<div class="col-sm-3">'+
						'<label><?php echo $lang['misc_date']; ?></label>'+
						'<input id="date" type="date" class="form-control" name="upload_date" value="'+today+'">'+
					'</div>'+
				'</div>'+
				'<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>'+
				'<div class="dz-success-mark"><span>✔</span></div>'+
				'<div class="dz-error-mark"><span>✘</span></div>'+
				'<div class="dz-error-message"><span data-dz-errormessage></span></div>'+
			'</div>';
	</script>

	<div class="row">
		<div class="col-sm-8">
			<h2>Ladda upp dokument</h2>
		</div>
		<div class="col-sm-4">
			<p class="bigmargin">
				<button id="submit-all" class="btn btn-success form-control">Submit all files</button>
			</p>
		</div>
	</div>
	<div class="alert alert-success hidden" id="queue-processed">
		<?php echo $lang['misc_done']; ?>
	</div>
	<form id="documents-dropzone" action="<?php echo site_url('admin/documents/upload'); ?>" class="dropzone">
		<div class="dz-message">
			<h1 class="text-center" style="font-size:500%;">
				<span class="glyphicon glyphicon-upload"></span>
			</h1>
			<p class="lead text-center">
				Drag och släpp dokument, eller klicka, här för att ladda upp dem.
			</p>
		</div>
		<!--
		TO DO: använd denna för att modifiera data som skickas med dropzone till servern.
		Detta genom att komma åt den via previewElement från file-objektet. Detta gör att data
		skickas automatiskt till myDropzone.on("sending", ...
		-->
		<!-- empty field where additional data will be added -->
		<div id="dropzone-fields"></div>
	</form>
</div><!-- /.main-box -->

<div class="main-box clearfix margin-top">
	<h2>Dokumentarkiv för <?php echo $group; ?></h2>

	<ul class = "document-list clearfix">
	<?php
	$protocols = array_slice($document_types, 0, 1);
	$document_types = array_slice($document_types, 1);

	foreach($protocols as $protocols_docs)
	{
		// Select year
		$form_options = array();

		$uri = explode('/', uri_string());

		if(sizeof($uri) == 5)			//admin_documents/overview/xxxx
			$dropdown_uri = '';
		else if(sizeof($uri) == 4) 		//admin_documents/overview
			$dropdown_uri = 'overview/';
		else if(sizeof($uri) == 3) 		//admin_documents
			$dropdown_uri = 'admin/documents/overview/';

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
				'<div class="row"><div class="col-3-4"><li class = "document clearfix"> <!-- TEMP LÖSNING MED col-3-4 etc -->
				<a href="' . base_url() . '/user_content/documents/'. $doc->document_original_filename .'">
					<i class = "-icon-document"></i>
					<h4>'. $doc->document_title . '</h4>
					<small>' . date("d M, Y", strtotime($doc->upload_date)) . '</small>
				</a>
				</div>
				<div class="col-4">'.anchor('admin/documents/delete/'.$doc->id,"Delete").
				'</li>
				</div>
				</div>';
			}
		}
	}

	foreach ($document_types as $type) {

		echo '<h3 style="clear: both">'.$lang['document_'.$type->document_type].'</h3>';

		foreach ($type->documents as $doc) {
			echo
			'<div class="row"><div class="col-3-4"><li class = "document clearfix"> <!-- TEMP LÖSNING MED col-3-4 etc -->
			<a href="' . base_url() . '/user_content/documents/'. $doc->document_original_filename .'">
				<i class = "-icon-document"></i>
				<h4>'. $doc->document_title . '</h4>
				<small>' . date("d M, Y", strtotime($doc->upload_date)) . '</small>
			</a>
			</div>
			<div class="col-4">'.anchor('admin/documents/delete/'.$doc->id,"Delete").
			'</li>
			</div>
			</div>';

		}
	}
	?>
	</ul>
</div>
