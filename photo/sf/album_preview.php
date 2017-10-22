<?php // Display album preview

function display_album_preview($uid, $caid, $album_preview_destinaiton){
	

	// Logger
	if(!isset($log)){
		$log = new Log;
	}
	$log->info("Display album preview");
	$log->debug("User ID", "\$uid", $uid);
	$log->debug("Current album id ", "\$caid", $caid);
	// Set link destination page of each album
	if (!isset($album_preview_destinaiton)) {
		$album_preview_destinaiton = "../photo/index.php";
	}
	$log->debug("Album preview", "\$album_preview_destinaiton", $album_preview_destinaiton);

	// Get function
	if (!function_exists("get_album"))
		require_once('get_album.php');
		
		
	// Get user id
/*	$uid;
	if (isset($_SESSION['user_id'])) {
		$uid = $_SESSION['user_id'];
	} else {
		$uid = 1;
	}
*/	 
	 
	// Get current album id
	$caoi;
	$a;
	$caid;

	if (isset($caid)) {
		$a = get_album("user_id = $uid AND album_id=$caid");
		if ($a) {
			$caoi = $a['order_id'];
			$log->debug("Got Current Album Order ID", "\$caoi", $caoi);
		} else { // If can't find the album
			//echo "Can't find album.";
			//exit();
			return;
		}
	} 
/*	if (isset($_GET['album'])) {
		$caid = $_GET['album'];	
		$a = get_album("user_id=$uid AND album_id=$caid");
		if ($a)
			$caoi = $a['order_id'];
		else {	// If can't find the album
			//echo " No, Can't find album.";
			//exit();
			return;
		}
	} */
	else {
		$caoi = 1;
		$a = get_album("user_id = $uid AND order_id=$caoi");
		if ($a)
			$caid = $a['album_id'];
		else {	// If can't find the album
			//echo "Can't find album.";
			//exit();
			return;
		}
	}

	$a = get_albums("user_id = $uid ORDER BY order_id ASC");
	$count = count($a);
	if ($a) {
		// Album preview 
		echo '<div id="album_preview">';
		
		// Display previous button
		echo '<span>';	
		$v = get_album("album_id=$caid LIMIT 1");

		if ($v){
				$oi = $v['order_id']-1;
				$a1 = get_album("user_id=$uid AND order_id=$oi");
				if ($a1){
					echo '<span title="' . $a1['album_id'] . '"><a id="album_nav_prev" href="' . $album_preview_destinaiton . '?album=' . $a1['album_id'] . '" title="' . $a1['album_name'] . '" style="display:block; cursor:pointer;"><</a></span>';	
					} else {
						echo '<span title=""><a id="album_nav_prev" href="' . $album_preview_destinaiton . '?" title="" style="opacity:0.0; cursor:default;"><</a></span>';
				}

		}
		echo '</span><span><ul id="album_preview_list">';
	//	echo $caid;
		$array;
		for ($c=0; $c<count($a); $c++) {
			if ((($c+1) >= (($caoi-1)-(($caoi-1)%10))+1) && (($c+1) <= (($caoi-1)-(($caoi-1)%10))+10)) { // Choose 10 album previews
				if (!function_exists("get_image"))
					require_once('get_image.php');
				$ac = $a[$c]['album_cover'];
				$a1 = get_image("image_id=$ac LIMIT 1","t");
				$a2 = get_image("album_id=" .  $a[$c]['album_id'] . " ORDER BY order_id ASC", "w");

					// Display album preview				
						echo '<li>
								<span title="' . $a[$c]['order_id'] . '">';

								echo '<a ' ;
								if ( $a[$c]['album_id'] == $caid) {

									echo 'id="current_album" ';
									//$a[$c]['current_page'] = 1;
								} else {
									//$a[$c]['current_page'] = 0;
								}
								 echo ' class="album_preview" href="' . $album_preview_destinaiton . '?album=' . $a[$c]['album_id'] . '&amp;album_name=' . $a[$c]['album_name'] . '" title="'. $a[$c]['album_name'] . '">
									<img src="' . $a1['image_path'] . '" alt="' . $a[$c]['album_id'] . '+' . $a2['image_id'] . '" style="';
									
								if ( $a[$c]['album_id'] == $caid)
									echo 'border:3px solid #09C';
								else 
									echo 'border:1px solid #666';
								echo '"/></a></span><br/>'							
								 . $a[$c]['album_name'] . '
								
							  </li>';					  
			}	
			
			// Get page numbers
			if (($c+1)%10 == 1) {
				$array[($c-($c%10))/10] = $a[$c];
				
				// Determine the current page
				if ($caoi >= ($c+1) && $caoi <= ($c+10)) {	// if current album is in the range
					$array[($c-($c%10))/10]['current_page'] = 1;
					
				}
						 
				//echo $array[($c-($c%10))/10]['current_page'];
			}

		}
		

		echo "</ul>";
		echo "</span><span>";


		// Generate next button
		$v = get_album("album_id=$caid LIMIT 1");
		if ($v){
				$oi = $v['order_id']+1;
				$a2 = get_album("user_id=$uid AND order_id=$oi");

				if ($a2){
						echo '<span title="' . $a2['album_id'] . '"><a id="album_nav_next" title="' . $a2['album_name'] .  '" href="' . $album_preview_destinaiton . '?album=' . $a2['album_id'] . '" style="display:block; cursor:pointer;">></a></span>';	
				} else {
					echo '<span title=""><a id="album_nav_next"  title="" href="' . $album_preview_destinaiton . '?" style="opacity:0.0; cursor:default;">></a></span>';
				}

		}
		

		echo "</span>";
		
		// Generate page numbers
		echo '<div id="album_page">';
	//	echo count($array);
		if(count($array) > 1){
			for ($c=0; $c < count($array); $c++) { // count through page number
				//$v = ($c-1) * 10 + 1;	// Get order id for the first album on each page
				if ($c > 0) // Add separator
					echo '<span> - </span>';
		//		if($array[$c]['current_page'])
		//			echo "yes";
				//echo $array[$c]['current_page'];
				echo '<span';
					echo ' title="' . $array[$c]['album_name'] . '"';
				echo '><a ';
				if (isset($array[$c]['current_page']) && ($array[$c]['current_page'] == 1)) { // If the page belongs to that of current album
					echo 'id="current_page" ';
				}
				echo ' class="album_page" href="' . $album_preview_destinaiton . '?album=' . $array[$c]['album_id'] . '">' . ($c+1) . '</a></span>';
			}
		}
		echo '</div>';
				
			  echo'</div>'; // End of album preview
	} else {
		
	}
}
?>