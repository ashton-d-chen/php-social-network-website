


tran_fade = function(in_id, in_url, in_cb, out_id, out_url, out_cb, delay){
	
	// Show success or fail
	get_content(in_id, in_url, in_cb);
	
	setTimeout(get_content(out_id, out_url, out_cb), delay);

	// Redirect to
}