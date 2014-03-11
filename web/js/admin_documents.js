$(document).ready(function() {
	// dropzone setup
	Dropzone.options.documentsDropzone = {
		// Prevents Dropzone from uploading dropped files immediately
		autoProcessQueue: false,
		maxFiles: 100,
		uploadMultiple: false,
		parallelUploads: 3,

		// AcceptedFiles and maxFilesize are set in documents_model
		acceptedFiles: ACCEPTEDFILES,
		maxFilesize: MAXFILESIZE,
		previewsContainer: document.querySelector("#dropzone-fields"),
		previewTemplate: PREVIEW,

		init: function() {
			var submitButton = document.querySelector("#submit-all");
			$("#submit-all").hide();
			documentsDropzone = this; // closure

			submitButton.addEventListener("click", function() {
				documentsDropzone.processQueue(); // Tell Dropzone to process all queued files.
			});

			documentsDropzone.on("complete", function(file) {
				// documentsDropzone.removeFile(file);

				if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
				{
					console.log('Que done');
					$("#queue-processed").removeClass('hidden');
				}
				else if(this.getUploadingFiles().length < 3 && this.getQueuedFiles().length > 0)
				{
					documentsDropzone.processQueue();
				}
			});

			documentsDropzone.on("sending", function(file, xhr, formData) {
				// get the inputs
				var inputs = $(file.previewElement.children).find('input, select');
				for (var i = inputs.length - 1; i >= 0; i--)
				{
					// append input to formdata
					input = inputs[i];
					console.log(input.name + "=" +input.value);
					formData.append(input.name, input.value);
				};
				console.log(formData);
			});

			// You might want to show the submit button only when
			// files are dropped here:
			this.on("addedfile", function(file){
				$("#submit-all").show();
				// console.log(file);
			});
		}
	};

    // listen to change on dynamically created objects
    $(document).on('change', 'select[name="document_type"]', function(event){
    	var title = $(this).closest('.row').find('input[name="title"]');
    	var description = $(this).closest('.row').find('input[name="description"]');
    	var date = $(this).closest('.row').find('input[name="upload_date"]');
		if ($(this).val()=="1")
		{
			title.val("Styrelsemöte");
			description.val("Protokoll från styrelsemötet " + date.val());
			title.attr('disabled', 'disabled');
			description.attr('disabled', 'disabled');
		}
		else if($(this).val()=="1_autumn")
		{
			title.val("Höstmöte");
			description.val("Protokoll från höstmötet " + date.val());
			title.attr('disabled', 'disabled');
			description.attr('disabled', 'disabled');
		}
		else if($(this).val()=="1_spring")
		{
			title.val("Vårmöte");
			description.val("Protokoll från vårmötet " + date.val());
			title.attr('disabled', 'disabled');
			description.attr('disabled', 'disabled');
		}
		else
		{
			title.val("");
			description.val("");
			title.removeAttr('disabled');
			description.removeAttr('disabled');
		}
	});

	$(document).on('change', 'input[name="upload_date"]', function(event){
		console.log($(this).val());
    	var type = $(this).closest('.row').find('select[name="document_type"]');
    	var description = $(this).closest('.row').find('input[name="description"]');
		if (type.val() == "1")
		{
        	description.val("Protokoll från styrelsemötet " + $(this).val());
        }
        else if(type.val() == "1_autumn")
        {
        	description.val("Protokoll från höstmötet " + $(this).val());
        }
        else if(type.val() == "1_spring")
        {
        	description.val("Protokoll från vårmötet " + $(this).val());
        }
	});

});
