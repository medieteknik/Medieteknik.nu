
$(document).ready(function(){
	// create carousel
	$('.carousel').carousel({
		interval: 15000
	});
	// toogle tooltips
	$('[data-toggle="tooltip"]').tooltip();

	// confirm delete
	$('#delete').click(function(event) {
		return confirm("Are you sure you want to delete?");
	});
})
