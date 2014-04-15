
$(document).ready(function(){
	// create carousel
	$('.carousel').carousel({
		interval: 15000
	});
	// toogle tooltips
	$('[data-toggle="tooltip"]').tooltip();
	// add dropdowns
	$('.dropdown-toggle').dropdown();

	// confirm delete
	$('#delete, [data-toggle="delete"]').click(function(event) {
		return confirm("Are you sure you want to delete? This can not be undone.");
	});

	// forum report reply
	$('.report a.toggle').click(function(event){
		event.preventDefault();
		$(this).addClass('hidden');
		$(this).siblings('.confirm').removeClass('hidden');
	});

	$('.report a.confirm').click(function(event) {
		event.preventDefault();
		$(this).text('...');

		var post_data = {'postid': $(this).attr('data-id')},
			btn = $(this);

		$.ajax({
			type: 'POST',
			url: BASE_URL + "en/forum/report",
			dataType: 'json',
			data: post_data
		})
		.done(function(data) {
			console.log(data);
			if(data.status == 'success')
			{
				console.log('ok');
				btn.siblings('.thanks').removeClass('hidden');
				btn.addClass('hidden');
			}
		});
	});

	$('a.forum-load').click(function(event){
		event.preventDefault();
		console.log('Loading more forum posts from thread ' + $(this).attr('data-thread'));

		// do nice load here.

		$(this).append('...');
		window.history.pushState("string", "Title", $(this).attr('href'));
		$('#forum-load').delay(800).slideUp('fast');
		$('.forum-reply.hidden').hide().removeClass('hidden').delay(1000).slideDown('slow');
	});

	$('#post_date_now').click(function(event){
		event.preventDefault();
		var d = new Date(),
			now = d.getFullYear()+"-"+(d.getMonth() < 10 ? "0":"")+d.getMonth()+"-"+d.getDate()+"T"+d.getHours()+":"+d.getMinutes();
		$('input[type=datetime-local]').val(now);
	});

	$('[data-toggle="preview"]').click(function(event){
		event.preventDefault();
		var target 	= $(this).attr('data-target'),
			text 	= $(this).attr('data-text'),
			btn 	= $(this);

		console.log('Previewing text ' + $(text).val());
		btn.button('loading');

		$.ajax({
			url: BASE_URL+'en/api/forum/markdown_preview',
			type: 'POST',
			dataType: 'json',
			data: {'text': $(text).val()},
		})
		.done(function(response){
			if(response.status === "success")
			{
				console.log("success");
				console.log(response);

				$(target + ' .content').html(response.result);
				$(target + '.hidden').hide().removeClass('hidden').slideDown('fast');
			}
		})
		.fail(function(){
			console.log("error");
			window.alert("Something went wrong. Sorry!");
		})
		.always(function(){
			btn.button('reset');
		});

	});
})
