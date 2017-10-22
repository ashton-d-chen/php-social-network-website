<?php
// Take a file name as parameter and returns its extension
function findexts ($filename) {
	$filename = strtolower($filename) ;
	$exts = preg_split("[/\\.]", $filename) ;
	$n = count($exts)-1;
	$exts = $exts[$n];
	return "." . $exts;
} 	
?>