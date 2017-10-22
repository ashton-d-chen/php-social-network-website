// display error message

function display_error(msg){
	
}
function fade_content(frame_id, content_id, get_url, callback){
	return	$.get(get_url, function(msg){
			
			// Check error
			if (msg.search('class="error"')) {  // If there is an error
				return msg;
			}
			
			var wait_before_fadeout = 100;
			var fadeout_time = 500;
			var fadein_time = 500;
			var wait_before_replace = 10;
			
			// Delay after click
			setTimeout( function() {
				$("#" + content_id).show().fadeOut(fadeout_time,"linear","");
			}, wait_before_fadeout );
			
			// Replace content
				// Replace Content
				setTimeout( function() {
					$("#" + content_id).html('');
					$("#" + frame_id).append('<div id="' + content_id + '"></div>');
					$("#" + content_id).hide();
					$("#" + content_id).append(msg);	
				}, fadeout_time + wait_before_fadeout );		
					
			// Delayed Fade In
			setTimeout( function() {
				$("#" + content_id).hide().fadeIn(fadein_time,"linear","");
			}, fadeout_time + wait_before_fadeout);				
	
			
			if (callback != "")
				$.getScript(callback);
			
			return "";
		});
}