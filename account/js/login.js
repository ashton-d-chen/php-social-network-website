$("#loginout").on("click",login);	

// g script request
function login(){

		var fade_object = get_content("#content","../account/login.php?tp=8292501", function(){login_submit();});
		
		// Error handling
		if ( fade_object.search('class="error"') >= 0) { // if an error message is returned
			$("curtain").prepend(fade_object);	
		}
}
		

// Sumit login form	
function login_submit(){

  $('.error').hide();
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"#FFDDAA"});
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });

  $("#li_submit").on("click",function() {
		// validate and process form
		// first hide any error messages
	alert("clicked");

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
		alert("test1");
		$.ajax({
      type: "POST",
      url: "../account/login.php",
      data: dataString,
      success: function(msg) {
			alert("test");
			window.location = "http://" + window.location.hostname + "/home/index.php";
			if ( msg.search('class="error"') >= 0) { // if an error message is returned
				$("#content").prepend(msg);	
				return;
			}
			

			fade_transit("#content", '<div id="content"><h2>You successfully login.</h2></div>');
			fade_transit("#loginout", msg);
			
			
			var fade_object = get_content("#content","../home/index.php?tp=8292501", "");
			
			$("#loginout").off("click", login);
			$.getScript("../account/js/logout.js");				
			window.location = "http://" + window.location.hostname + "/home/index.php";			
	
      }
     });
    return false;
	});

}

runOnLoad(function(){
  $("input#email").select().focus();
});

