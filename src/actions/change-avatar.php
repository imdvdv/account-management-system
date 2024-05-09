<?php

include_once __DIR__ . "/../config/includes.php";
include_once __DIR__ . "/../helpers/file-upload.php";
include_once __DIR__ . "/../helpers/update-avatar.php";

session_start();

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

if (isAuthorized()) {

    $userID = $_SESSION["user"]["id"];
    $method = $_SERVER["REQUEST_METHOD"];

    if ($method === "POST"){

        // Validation avatar
        if (isset($_FILES["avatar"])) {

            $filesData = validateFiles($_FILES); // the function will return an array with files and an array of errors

            if (isset($filesData["avatar"]) && !isset($filesData["errors"]["avatar"])){

                // Upload a new user avatar
                if (updateAvatar($userID, $filesData["avatar"])){

                    $statusCode = "HTTP/1.1 200 OK";
                    $responseData = [
                        "status" => true,
                        "url" => "{$_SERVER['HTTP_REFERER']}"
                    ];
                }
            } else {
                $responseData["errors"] = $filesData["errors"];
            }
        }
    } else {
        $statusCode = "HTTP/1.1 405 Method Not Allowed";
    }
} else {
    $statusCode = "HTTP/1.1 401 Unauthorized";
}

header($statusCode);
echo json_encode($responseData);
exit;