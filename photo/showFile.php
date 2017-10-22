<table align="center" cellspacing="5" cellpadding="5" border="1">
	<tr>
		<td align="center"><b>Image Name</b></td>
		<td align="center"><b>Image Size</b></td>
	</tr>

<?php # images.php
// This script lists the images in the uploads directory.

$dir = './uploads'; // Define the directory to view.

$files = scandir($dir); // Read all the images into an array.

// Display each image caption as a link to the JavaScript function:
foreach ($files as $image) {

	if (substr($image, 0, 1) != '.') { // Ignore anything starting with a period.
	
		// Get the image's size in pixels:
		$image_size = getimagesize ("$dir/$image");
		
		// Calculate the image's size in kilobytes:
		$file_size = round ( (filesize ("$dir/$image")) / 1024) . "kb";
		
		// Make the image's name URL-safe:
		$image = urlencode($image);
		
		// Print the information:
		echo "\t<tr>
\t\t<td><a href=\"javascript:create_window('$image',$image_size[0],$image_size[1])\">$image</a></td>
\t\t<td>$file_size</td>
\t</tr>\n";
	
	} // End of the IF.
    
} // End of the foreach loop.
	echo "</table>";
?>