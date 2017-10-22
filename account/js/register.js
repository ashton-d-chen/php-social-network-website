$("#register").live("click",function(){
	var href = $(this).attr("href");
	$(this).attr("href","#");
	get_content("#content", href + "?tp=242", "");

});