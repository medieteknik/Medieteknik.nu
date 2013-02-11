(function(){
	;
	$.post('http://127.0.0.1/Medieteknik.nu/index.php/ajax_post/get_images', function(data){
		var imagePanel = "<p>Images on server:</p><div class='image-panel'>" + data[0] + "</div>";
		$('#image-edit').append(imagePanel);
	}, 'json');
})();