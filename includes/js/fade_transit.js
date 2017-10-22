// Faede out, load new content, and fade in
			
function fade_transit(content, message){			

	var wait_before_fadeout = 100;
	var fadeout_time = 500;
	var fadein_time = 500;
	var wait_before_replace = 10;
	
	
	
	// Delay after click
	setTimeout( function() {
		$(content).show().fadeOut(fadeout_time,"linear","");
	}, wait_before_fadeout );
	// Replace content
		// Replace Content
		setTimeout( function() {
	
		$(content).hide();
				

		$(content).replaceWith(message);
		

		}, fadeout_time + wait_before_fadeout );		
			
	// Delayed Fade In
	setTimeout( function() {
		$(content).hide().fadeIn(fadein_time,"linear","");
	}, fadeout_time + wait_before_fadeout);				

}

function fade_transition(content, message){			

	var wait_before_fadeout = 100;
	var fadeout_time = 500;
	var fadein_time = 500;
	var wait_before_replace = 10;
	
	
	
	// Delay after click
	setTimeout( function() {
		$(content).show().fadeOut(fadeout_time,"linear","");
	}, wait_before_fadeout );
	// Replace content
		// Replace Content
		setTimeout( function() {
	
		$(content).hide();
				

		$(content).html(message);
		

		}, fadeout_time + wait_before_fadeout );		
			
	// Delayed Fade In
	setTimeout( function() {
		$(content).hide().fadeIn(fadein_time,"linear","");
	}, fadeout_time + wait_before_fadeout);				

}

