//$(function() {
//	$("#image_container img[rel]").overlay({effect: 'apple'});
//});


// 1. Bind album preview images
$("#display").delegate(".album_preview", "click", function(){	

	select_album($(this));
	$(this).attr("href","#");
});

// 2. 
function select_album(selector) {

	var array = selector.children().attr("alt").split("+");

	// Refresh album preview image list

	// Update current album 
	update_current("current_album", selector);

	// Update previous and next navigation button
	update_nav(selector, '.album_preview', "#album_nav_prev",'#album_nav_next');

	// Add album id to #album_name_container

	// Update album title
	display_album_title(selector);
	
	$(".preview_image_item").each(function(){
			$(this).removeAttr("class");
	});
	
	get_content("#preview_image_list","../photo/sf/album_image_preview.php?album=" +  array[0], "");
	
	// Refresh image
	get_content("#image_container a", "../photo/sf/display_image.php?image=" +  array[1], "");
}

// 3. Update current item
function update_current(current, selector){

	// Reset highlight
	$('#' + current).children().attr("style", selector.children().attr("style"));

	// Reset id
	$('#' + current).removeAttr("id");	

	// Set this album as current album
	selector.attr("id",current);

	// Set highlight
	selector.children().attr("style","border:3px solid #09C");
}

// 4. Update navigation arrows
function update_nav(selector, class_set, prev, next){

	// save album id to alt in the title element
	var order = parseInt(selector.parent().attr("title"));
	// Get previous album id
	var prev_item = $(selector).parent().parent().prev().children().children().attr("title");
	
	// Get next album id
	var next_item = $(selector).parent().parent().next().children().children().attr("title");
	
	// Hide previous button if current album is the first album in the preview list
	if (order <= 1) {
		$(prev).animate({opacity:0.0});
		$(prev).removeAttr("title");
		$(prev).removeAttr("alt");
		$(prev).css("cursor", "default");
	}
	
	// Hide next button if current album is the last album in the preview list
	if ((order-1)%10+1 >= $(class_set).length && $("#current_page").parent().next().next().children().attr("href") == undefined) {
		$(next).animate({opacity:0.0});
		$(next).removeAttr("title");
		$(next).removeAttr("alt");
		$(next).css("cursor", "default");
	}
	
	//	Show next or previous button
	if ((order-1)%10+1 <($(class_set).length)) {
		$(next).attr("title", next_item);	
		$(next).animate({opacity:1.0});
		$(next).css("cursor", "pointer");
	} else { // If current album is the last album in the preview list
		$(prev).attr("title", prev_item);
	}		
	
	if ((order-1)%10+1 > 1) { // If current album order > 1, display navigation button
		$(prev).attr("title", prev_item);
		$(prev).animate({opacity:1.0});
		$(prev).css("cursor", "pointer");
	} else { // If current album is the first album in the preview list
		$(next).attr("title", next_item);
	}
	
	// If current album is the first one in the list, get previous page's album name
	if ((order-1)%10+1 <= 1 && $("#current_page").parent().prev().prev().children().attr("href") != undefined) {
		$(prev).attr("title", $("#current_page").parent().prev().prev().attr("title"));
	}		
	
	
	// If current album is the last one in the list, get next page's album name
	if ((order-1)%10+1 >= 10 && $("#current_page").parent().next().next().children().attr("href") != undefined) {
		$(next).attr("title", $("#current_page").parent().next().next().attr("title"));
	}	
}

// Update album title
function display_album_title(selector){

	fade_transit('#album_name_container', '<div id="album_name_container">' + selector.attr("title") + '</div>');
}

// Bind album navigation previous button
$("#album_nav_prev").die("click");
$("#album_nav_prev").live("click",function(){
	$(this).attr("href","#");

	if (parseInt($("#current_album").parent().attr("title"))%10 != 1) {
			select_album($("#current_album").parent().parent().prev().children().children());
	} else {
		if ($("#current_page").parent().prev().prev().children().attr("href") != "") {
			$("#current_page").parent().prev().prev().children().trigger('click');
		}
	}
	$(this).attr("href","#");
});

// Bind album navigation next button
$("#album_nav_next").die("click");
$("#album_nav_next").live("click",function(){

	if ((parseInt($("#current_album").parent().attr("title"))-1)%10+1 != ($(".album_preview").length)) { // If current item is not the last item,
			select_album($("#current_album").parent().parent().next().children().children());
	} else {	// If current is the last item in the list

		if ($("#current_page").parent().next().next().children().attr("href") != "") { // If next list exists

			$("#current_page").parent().next().next().children().trigger('click');
		}
	}
	$(this).attr("href","#");
});

/*********** Preview iamge item **********/

// 1. Bind preview image item
$("body").delegate(".preview_image_item", "click", function(){		
		
		select_image($(this));
		$(this).attr("href", "#");
});


// 2. 
function select_image(selector) {
	
	
	
	// Update current album 
	update_current("current_image", selector);
	
	// Update previous and next navigation button
	update_nav(selector, '.preview_image_item', "#image_nav_prev",'#image_nav_next');
	
	// Refresh image
	get_content("#image_container a", "../photo/sf/display_image.php?image=" +  selector.children().attr("alt"), "");
}

$("#image_nav_prev").die("click");
$("#image_nav_prev").live("click",function(){
	// Get previous element
	$(this).attr("href","#");
	if (parseInt($("#current_image").parent().attr("title")) != 1) {
			select_image($("#current_image").parent().parent().prev().children().children());
	}
	
	$(this).attr("href","#");

	if (parseInt($("#current_image").parent().attr("title"))%10 != 1) {
			select_album($("#current_image").parent().parent().prev().children().children());
	}
});

// Bind image navigation next button
$("#image_nav_next").die("click");	// Remove previous memory
$("#image_nav_next").live("click",function(){
	$(this).attr("href","#");
	if (parseInt($("#current_image").parent().attr("title")) != ($(".preview_image_item").length)) {
			select_image($("#current_image").parent().parent().next().children().children());
	}
});


// Bind page number button 
$("#display").delegate(".album_page", "click", function(){	
	
	// Extract link info from href attribute
	var j = $(this).attr("href") ;
	
	// Acquire album and image info
	j = j.split("?");
	
	// Disable hyerlink
	$(this).attr("href","#");
	
	// Refresh content
	get_content("#content", "../photo/index.php?tp=24242489&" + j[1], "");
});

/*
var next = nav_prev("#image_nav_prev","#current_image");
alert("1");
var next = nav_next("#image_nav_next", "#current_image", ".preview_image_item");

// Bind previous navigation button
function nav_prev(prev,current){
	$(prev).live("click",function(){
		// Get previous element
		alert("2");
		if (parseInt($(current).parent().attr("title")) != 1) {
				select_image($(current).parent().parent().prev().children().children());
		}
	});
}

// Bind next navigation button
function nav_next(next, current, class){
	// Bind album navigation next button
	
	$(next).live("click",function(){
		if (parseInt($(current).parent().attr("title")) != ($(class).length)) {
				select_image($(current).parent().parent().next().children().children());
		}
	});
}
*/


