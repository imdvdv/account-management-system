<?php

function fileUpload (array $file, string $extendedPath = null) :string|false {

    // Upload path initialization
    $relativeUploadPath = "/uploads"; // default uploads path
    $absoluteUploadPath = "{$_SERVER["DOCUMENT_ROOT"]}/uploads";

    if ($extendedPath !== null){
        $relativeUploadPath = "$relativeUploadPath/$extendedPath"; // add extended path to default path if it passed
        $absoluteUploadPath = "$absoluteUploadPath/$extendedPath";
    }

    // Check the uploads directory exist and make it if it's not
    if (!is_dir($relativeUploadPath)){
        mkdir($relativeUploadPath, 0777, true);
    }
    // Prepare the file data
    $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $fileName = date("Y-m-d_H-i-s") . "_" . bin2hex(random_bytes(5)) . ".$fileExtension";
    $relativeFilePath = "$relativeUploadPath/$fileName";
    $absoluteFilePath = "$absoluteUploadPath/$fileName";

    // If the file was successfully uploaded to the server the function will return its path, otherwise will return false
    if (move_uploaded_file($file["tmp_name"], $absoluteFilePath)){
        return $relativeFilePath ;
    }
    return false;
}