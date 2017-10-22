// Fade content and execute scirpt once success

function get_content(content, get_url, callback){
	return $.get(get_url, function(message){
		
		// If server returns message, display it
			// Fade transit
			fade_transit(content, message);
	
			// execute callback
			if (callback != "")
				callback();		
			return message;

	});

}

function get_contents(content, get_url, callback){
	var result = "";
	$.get(get_url, function(message){
			// Fade transit
			//fade_transition(content, message);
			$(content).html(message);
			// execute callback
			if (callback != "")
				callback();		
			result = message;
			
	});
	return result
}






