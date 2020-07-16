$(document).ready(function(){
	var offset = new Date().getTimezoneOffset();
	var timestamp = new Date.getTime();
	var utc_timestamp = timestamp + (60000 * offset);
    //Return the number of milliseconds since 1970/01/01:*/
	$('#time_zone_offset').val(offset);
	//Convert our time to Universal time coordinated/ Universal Coordinated time */
	$('#utc_timestamp').val(utc_timestamp);

	
	});