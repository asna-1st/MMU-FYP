<?php

if(isset($_FILES["file"]["tmp_name"])){
    $filename = $_FILES["file"]["tmp_name"];

    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    $file_ext = strtolower($file_ext);

    $valid_ext = array("jpg", "png", "gif", "jpeg", "svg", "webp", "avif", "apng", "bmp", "ico", "tiff", "tmp");
    $response = null;

    if(in_array($file_ext, $valid_ext)){
        $imgData = base64_encode(file_get_contents($filename));
        $src = 'data: '.mime_content_type($filename).';base64,'.$imgData;
        $response = $src;
    } else {
        $response = 0;
    }

    echo $response;
    unlink($filename);
    die();
    exit();
}
?>