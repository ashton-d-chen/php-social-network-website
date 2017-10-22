<?
function delete_directory($dir) { 
   $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? delete_directory("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
  } 
?>