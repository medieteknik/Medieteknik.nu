<?php
echo '
<div class="main-box clearfix">
<div class="dropzone-outer">'; //to combine normal form with dropzone
?>

<!--	Load dropzone 	-->
<script src="<?php echo base_url(); ?>web/js/libs/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>web/js/libs/dropzone.min.js"></script>

<script type="text/javascript">
	Dropzone.options.myDropzone = {

	  // Prevents Dropzone from uploading dropped files immediately
	  autoProcessQueue: false,
	  maxFiles: 1,

	  // AcceptedFiles and maxFilesize are set in documents_model
	  acceptedFiles: '<?php echo $config['acceptedFiles']; ?>',
	  maxFilesize: '<?php echo $config['maxSize']; ?>',

	  init: function() {
	    var submitButton = document.querySelector("#submit-all")
	        myDropzone = this; // closure

	    submitButton.addEventListener("click", function() {
	      myDropzone.processQueue(); // Tell Dropzone to process all queued files.
	    });

	    this.on("complete", function() {
	      // Handle the responseText here. For example, add the text to the preview element:
	      location.reload();
	    });

	    // You might want to show the submit button only when 
	    // files are dropped here:
	    this.on("addedfile", function() {
	      // Show submit button here and/or inform user to click it.
	    });
	  }
	};
</script>
<script type="text/javascript">

	$(document).ready(function() {
		$('#title').val("Styrelsemöte");
	    $('#description').val("Protokoll från styrelsemötet " + $('#date').val());

	    $('#type').change(function() {
	        if ($(this).val()=="1") {
	        	$('#title').val("Styrelsemöte");
	        	$('#description').val("Protokoll från styrelsemötet " + $('#date').val());
	        	$('#title').attr('disabled', 'disabled');
	        	$('#description').attr('disabled', 'disabled');
	        } else if($(this).val()=="1_autumn") {
	            $('#title').val("Höstmöte");
	        	$('#description').val("Protokoll från höstmötet " + $('#date').val());
	        	$('#title').attr('disabled', 'disabled');
	        	$('#description').attr('disabled', 'disabled');
	        }else if($(this).val()=="1_spring") {
	            $('#title').val("Vårmöte");
	        	$('#description').val("Protokoll från vårmötet " + $('#date').val());
	        	$('#title').attr('disabled', 'disabled');
	        	$('#description').attr('disabled', 'disabled');
	         }else {
	        	$('#title').val("");
	        	$('#description').val("");
	        	$('#title').removeAttr('disabled');
	        	$('#description').removeAttr('disabled');
	        }

	    });

		$('#date').change(function() {
			if ($('#type').val()=="1") {
	        	$('#description').val("Protokoll från styrelsemötet " + $('#date').val());
	        } else if($('#type').val()=="1_autumn") {
	        	$('#description').val("Protokoll från höstmötet " + $('#date').val());
	        }else if($('#type').val()=="1_spring") {
	        	$('#description').val("Protokoll från vårmötet " + $('#date').val());
	        }
		});

	});
</script>


<h2>Ladda upp dokument</h2>
<form id="my-dropzone" action="<?php echo site_url('admin_documents/upload'); ?>" class="dropzone">
		<div class="dropzone-normal-form">
			<select id="type" name="document_type">
				<option value="1"><?php echo $lang['document_protocol'].' - '.$lang['document_protocol_normal']?></option>
				<option value="1_autumn"><?php echo $lang['document_protocol'].' - '.$lang['document_documents_meeting_autumn']?></option>
				<option value="1_spring"><?php echo $lang['document_protocol'].' - '.$lang['document_documents_meeting_spring']?></option>
				<option value="3"><?php echo $lang['document_documents_meeting_autumn']?></option>
				<option value="4"><?php echo $lang['document_documents_meeting_spring']?></option>
				<option value="2"><?php echo $lang['document_directional_document']?></option>
			</select></br>
			<?php echo $lang['misc_title'].': ' ?><input id="title" type="text" size = "50" name="title" disabled="disabled"/>
			<?php echo $lang['misc_description'].': ' ?><input id="description" type="text" size = "50" name="description" disabled="disabled"/>
			<input id="date" type="date" name="date" value=<?php echo $theTime = date("Y-m-d H:i",time());?>>
		

</form></br>
<?php
//List documents
echo '
</div>
<button id="submit-all">Submit all files</button>
</div> <!--dropzone-outer-->
</div> <!--main-box-->
<div class="main-box clearfix">
<h2>Dokumentarkiv för ' . $group . '</h2>
<ul class = "document-list clearfix">';

$do_dump($document_types);
foreach ($document_types as $type) {
	echo '<h3>'.$lang['document_'.$type->document_type].'</h3>';
	foreach ($type->documents as $doc) {
		echo
		'<div class="row"><div class="col-3-4"><li class = "document clearfix"> <!-- TEMP LÖSNING MED col-3-4 etc -->
		<a href="' . base_url() . '/user_content/documents/'. $doc->document_original_filename .'">	
			<i class = "-icon-document"></i>
			<h4>'. $doc->document_title . '</h4>
			<small>' . date("d M, Y", strtotime($doc->upload_date)) . '</small>
		</a>
		</div>
		<div class="col-4">'.anchor('admin_documents/delete/'.$doc->id,"Delete").
		'</li>
		</div>
		</div>';

	}
}
echo '</ul>';
echo '</div>';
