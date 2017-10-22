<?php

if (!function_exists("get_image"))
	require_once('get_image.php');

if (!isset($pid) && isset($_GET['image'])){ // Request from client
	$pid = $_GET['image'];
} else if (isset($pid)){ // Request from another script

} else {
	exit();	
}

// Check current working folder
if (strstr(getcwd(), 'sf') != "") {
	chdir('../');
	include('../includes/config.inc.php');
	require_once(MYSQL);			
}
		
$a = get_image("image_id=$pid", "w");

if (!$a) {
	echo "<h2>Can't find the image you request</h2>";
	exit();
}

?>

<a class="image" href="../photo/index.php?album=<?php echo $a['album_id'];?>&amp;image=<?php echo $a['image_id'];?>">
	<img title="<?php $a['file_name'];?>" src="<?php echo $a['image_path'];?>" alt="<?php echo $a['image_id']; ?>"/>
    <div> <?php echo $a['description']; ?></div>
</a>


