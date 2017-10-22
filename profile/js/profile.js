// Fade in and fade out for profile page
$("#profile_menu").off("click", "a"); 		// Remove event handler
$("#profile_menu").on("click", "a", function(){	
		
		var href = $(this).attr("href");
		a = href.split('?');
		href = a[0] + "?tp=19834013";
		
		var previous_page = $("#current_page").attr('data-current-page') + "?tp=19834013";

		
		$("#previous_page").attr('data-previous-page', previous_page);
		
		// Disable href
		$(this).attr("href", "#");

		// Refresh display 
		get_content("#content", href, function(){
			$("body").off( "click", "#cancel_button");
		
			// Callback function for the cancel button to return to previous page
			$("body").on("click", "#cancel_button",  function(){
					get_content("#content", $("#previous_page").attr('alt'), "");	
			});
		});			


		
		
}); 