
<?php
if (!function_exists("get_image"))
	include_once('get_image.php');
	
if(!isset($uid) || !isset($caid)){ // If not requested from javasccript

	chdir('../');

	include_once('../includes/config.inc.php');
	include_once(MYSQL);

	if (isset($_SESSION['user_id']))
		$uid = $_SESSION['user_id'];
	else 
		$uid = 1;
		
	if (isset($_GET['album'])) {	
		$caid = $_GET['album'];

	
	} else {
	// if album was not specified, get album from default user
			$q = "SELECT album_id, album_name FROM albums WHERE ";					
			$r = @mysqli_query ($dbc, $q);
			get_album("user_id = 1 ORDER BY order_id ASC");
			if ($r) {
				$a = mysqli_fetch_array($r,MYSQLI_ASSOC);
				$caid = $a['album_id'];
				$cpid = $a['album_cover'];
			}
	}
}

// Check $cpid
if (!isset($cpid)) {
	if (isset($_GET['iamge']))
		$cpid = $_GET['iamge'];
	else {
		$a = get_image("album_id=$caid ORDER BY order_id ASC","");
		if($a)
			$cpid = $a['image_id'];
	}
}			


// Get images
$a = get_images("album_id=$caid ORDER BY order_id ASC","t");

if ($a) {
	echo '<div id="preview_image_list"><ul>';	
	//$c = 0;
/*	
	// Get current photo's order id
	$g = get_image("image_id=$cpid LIMIT 1","");
	if ($g) {
		
		$cpoi = $g['order_id'];
	}
	if ($cpoi > 1){
		$a1 = get_image("user_id=$uid AND order_id=". ($cpoi-1),"");
		if ($a1){
			echo '<li><a id="image_nav_prev" href="../photo/index.php?image=' . $a1['image_id'] . '" title="' . $a1['file_name'] . '" alt=' . $a1['image_id'] . '" style="display:block">' . $words['previous'] . '</a></li>';	
		}
	} else {
			echo '<li><a id="image_nav_prev" href="../photo/index.php?" title="" alt="" style="display:none">' . $words['previous'] . '</a></li>';
	}
	*/
	$g = get_image("image_id=$cpid LIMIT 1","");
	if ($g) {
		
		$cpoi = $g['order_id'];
	}
	
/*	
	if ($cpoi > 1){
		$a1 = get_image("user_id=$uid AND order_id=". ($cpoi-1),"");
		if ($a1){
			echo '<li><span><a id="image_nav_prev" title="' . $a1['file_name'] . '"  href="../photo/index.php?image=' . $a1['image_id'] . '" style="display:block">' . $words['previous'] . '</a></span></li>';	
		}
	} else {
			echo '<li><span><a id="image_nav_prev"  href="../photo/index.php" title="" style="display:none">' . $words['previous'] . '</a></span></li>';
	}*/
	
	$counter=0;
	for ($c=0; $c<count($a); $c++) {

		// get thumbnail size, and save the value into size array
		$t = IMAGE_UPLOAD_URL . "/" . $uid . "/" . $caid . "/t_" . $a[$c]['file_name'];
		// Display Image Thumbnail
		echo '<li><span title="' . ($c+1) . '"><a ';
		
		if ( $a[$c]['image_id'] == $cpid)
			echo 'id="current_image"';

		echo ' class="preview_image_item" href="../photo/index.php?album=' . $caid. '&amp;image=' . $a[$c]['image_id'] . '" ><img title="' . $a[$c]['file_name'] .'" src="' . $t . '" alt="' . $a[$c]['image_id'] . '" style="';
		
		if ( $a[$c]['image_id'] == $cpid)
			echo 'border:3px solid #09C';
		else 
			echo 'border:1px solid #666';
			
		echo '"/></a></span></li>'; 
		$counter++;
	}			
/*
	if (($cpoi+1) <= $counter) {
		$a1 = get_image("user_id=$uid AND order_id=". ($cpoi+1),"");
		if ($a1){
			echo '<li><a id="image_nav_next" href="../photo/index.php?image=' . $a1['image_id'] . '" title="' . $a1['file_name'] . '" alt="' . $a1['image_id'] . '" style="display:block">' . $words['next'] . '</a></li>';
		} 
	} else {
				echo '<li><a id="image_nav_next" href="../photo/index.php?" title="" alt="" style="display:none">' . $words['next'] . '</a></li>';
		}
*/		
/*
	if (($cpoi+1) <= $counter) {
		$a1 = get_image("user_id=$uid AND order_id=". ($cpoi+1),"");
		if ($a1){
			echo '<li><span><a id="image_nav_next"  title="' . $a1['file_name'] . '" href="../photo/index.php?image=' . $a1['image_id'] . '" style="display:block">' . $words['next'] . '</a></span></li>';
		} 
	} else {
				echo '<li><span><a id="image_nav_next"  href="../photo/index.php" title="" style="display:none">' . $words['next'] . '</a></span></li>';
		}*/
		
	echo '</ul></div>'; // End of preview image list
}

?>