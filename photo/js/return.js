// Fade in and fade out
$("#photo_menu").off("click", "a"); 		// Remove event handler
$("#photo_menu").on("click", "a", function(){	
		
		var href = $(this).attr("href");
		a = href.split('?');
		href = a[0] + "?tp=19834013";
		
		var previous_page = $("#current_page").attr('data-current-page') + "?tp=19834013";

		if ($("#current_album").length && $("#current_image").length){
			// Get current album ID
			var aid = $("#current_album").children().attr('alt').split('+')[0];

			// Get current image ID
			var pid = $("#current_image").children().attr("alt");

			// Reconstruct href
			
			href += "&album=" + aid + "&image=" + pid;

			previous_page += "&album=" + aid + "&image=" + pid;
			
		}
		$("#previous_page").attr('data-previous-page', previous_page);
		
		// Disable href
		$(this).attr("href", "#");

		// Refresh display 
		get_content("#content", href, function(){
			$("body").off( "click", "#cancel_button");
		
			// Callback function for the cancel button to return to previous page
			$("body").on("click", "#cancel_button",  function(){
					get_content("#content", $("#previous_page").attr('data-previous-page'), "");	
			});
		});			


		
		
}); 