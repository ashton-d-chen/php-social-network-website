//$("#upload").live("click",upload);	

// g script request
function upload(){
		// Error handling
		/*
		if ( fade_object.search('class="error"') >= 0) { // if an error message is returned
			$("#content").prepend(fade_object);	
		}
		*/
		
	$('.error').hide();
	$('input.text-input').css({backgroundColor:"#FFFFFF"});
	$('input.text-input').focus(function(){
	$(this).css({backgroundColor:"#FFDDAA"});
	});
	$('input.text-input').blur(function(){
	$(this).css({backgroundColor:"#FFFFFF"});
	});
	
	$("#li_submit").live("click",function() {
		// validate and process form
		// first hide any error messages
		
	
	$('.error').hide();
	
	var album = $("input#album").val();
	if (album == "") {
//		$("label#pass_error").show();
//		$("input#pass").focus();
//		return false;
		// Error handling
	}
		 // $('#message').append("<img id='checkmark' src='images/check.png' />");
		var dataString = 'tp=982xe&email=' + email + '&pass=' + pass +"&submitted=yes";
		//alert (dataString);return false;
	
		$.ajax({
	  type: "POST",
	  url: "../account/login.php",
	  data: dataString,
	  success: function(msg) {
	
		
			if ( msg.search('class="error"') >= 0) { // if an error message is returned
				$("#content").prepend(msg);	
				return;
			}
			
			fade_transit("#content", '<div id="content"><h2>You successfully login.</h2></div>');
			fade_transit("#loginout", msg);
			
			
			var fade_object = get_content("#content","../home/index.php?tp=8292501", "");
			
			$("#loginout").die("click", login);
			$.getScript("../account/js/logout.js");						
	
	  }
	 });
	return false;
	});		
		
}
		

// Sumit upload form	
function login_submit(){

  $('.error').hide();
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"#FFDDAA"});
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });

  $("#li_submit").live("click",function() {
		// validate and process form
		// first hide any error messages
		

	$('.error').hide();

	var email = $("input#email").val();
		if (email == "") {
      $("label#email_error").show();
      $("input#email").focus();
      return false;
    }

		var pass = $("input#pass").val();
		if (pass == "") {
      $("label#pass_error").show();
      $("input#pass").focus();
      return false;
    }
	
         // $('#message').append("<img id='checkmark' src='images/check.png' />");
		var dataString = 'tp=982xe&email=' + email + '&pass=' + pass +"&submitted=yes";
		//alert (dataString);return false;

		$.ajax({
      type: "POST",
      url: "../account/login.php",
      data: dataString,
      success: function(msg) {

		
			if ( msg.search('class="error"') >= 0) { // if an error message is returned
				$("#content").prepend(msg);	
				return;
			}
			
			fade_transit("#content", '<div id="content"><h2>You successfully login.</h2></div>');
			fade_transit("#loginout", msg);
			
			
			var fade_object = get_content("#content","../home/index.php?tp=8292501", "");
			
			$("#loginout").die("click", login);
			$.getScript("../account/js/logout.js");						
	
      }
     });
    return false;
	});
}

runOnLoad(function(){
  $("input#email").select().focus();
});

