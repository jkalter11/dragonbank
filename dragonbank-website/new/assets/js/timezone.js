$(document).ready(function() {
	var tz = jstz.determine(); // Determines the time zone of the browser client
	tz.name(); // Returns the name of the time zone eg "Europe/Berlin"
	$.ajax({
		type: "GET",
		url: "ajax/ajax_timezone",
		data: 'time='+ tz.name(),
		success: function(){
		}
	});
});