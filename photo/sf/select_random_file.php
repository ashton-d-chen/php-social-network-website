<?php
function select_random_file()
{
    $files = glob(DOCUMENT_ROOT . '/media/sample_images/*.*');
    $file = array_rand($files);
    return $files[$file];
}

?>