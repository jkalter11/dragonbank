$ = jQuery.noConflict();

$(document).ready(function() {
	$('#refresh-captcha').click(function(event){
			event.preventDefault();
			$(".form-group img").attr('src', 'order/new_captcha');
		});
});