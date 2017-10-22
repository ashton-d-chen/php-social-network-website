$("#loginout").on("click", logout);
   


function logout() {
	window.location = "http://" + window.location.hostname + "/home/index.php";
	//alert("1");
	var message = get_content("#loginout","../account/logout.php?tp=8292501", logout_submit);

	if ( message.search('class="error"') >= 0) { // if an error message is returned
		$("#content").prepend(message);	
		return;
	}
}

function logout_submit() {
	//var message = get_content("#content","../home/index.php?tp=8292501", "");
	
	$("#loginout").off("click", logout);
	$.getScript("../account/js/login.js");
}
