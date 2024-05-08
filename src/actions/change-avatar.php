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
        if (isset($_FILES["avatar"], $_FILES["avatar"]["size"]) && $_FILES["avatar"]["size"] > 0) {
            $avatar = $_FILES["avatar"];
            $fileError = validateFile("avatar", $avatar); 

            if (empty($fileError)){

                // Upload a new user avatar
                if (updateAvatar($userID, $avatar)){

                    $statusCode = "HTTP/1.1 200 OK";
                    $responseData = [
                        "status" => true,
                        "url" => "{$_SERVER['HTTP_REFERER']}"
                    ];
                }
            } else {
                $responseData["errors"] = $fileError;
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