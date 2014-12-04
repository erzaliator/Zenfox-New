$(function(){
	var note = $('#countDownNote'),
		ts = new Date(2012, 0, 1),
		newYear = true;
	
	if((new Date()) > ts){
		// The new year is here! Count towards something else.
		// Notice the *1000 at the end - time must be in milliseconds
		today = new Date();
		todays_date = today.getDate();
		todays_month = today.getMonth();
		ts = (new Date(2014,todays_month,todays_date-1,23,59,59)).getTime() + 1*24*60*60*1000;
		newYear = false;
	}
		
	$('#countdown').countdown({
		timestamp	: ts,
		callback	: function( hours, minutes, seconds){
			
			var message = "<span align='center'>Hours&nbsp;&nbsp;&nbsp;&nbsp;</span> <span align='center'>&nbsp;&nbsp;&nbsp;Mins&nbsp;&nbsp;&nbsp;</span><span align='center'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Secs&nbsp;&nbsp;&nbsp;</span>";
			
			
			note.html(message);
		}
	});
	
	$('#countdown1').countdown({
		timestamp	: ts,
		callback	: function( hours, minutes, seconds){
			
			var message = "<span align='center'>Hours&nbsp;&nbsp;&nbsp;&nbsp;</span> <span align='center'>&nbsp;&nbsp;&nbsp;Mins&nbsp;&nbsp;&nbsp;</span><span align='center'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Secs&nbsp;&nbsp;&nbsp;</span>";
			
			
			note.html(message);
		}
	});
	
});
