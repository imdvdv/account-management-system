<?php

include_once __DIR__ . "/../config/includes.php";
include_once __DIR__ . "/../helpers/update-avatar.php";
include_once __DIR__ . "/../helpers/delete-user.php";

session_start();

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

if (isAuthorized()){
    $userID = $_SESSION["user"]["id"];
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method === "DELETE") {

        // Delete user data
        updateAvatar($userID); // delete user avatar file from the uploads directory if it exists
        deleteUser($userID); // delete user data from the database

        // Prepare a positive response
        $responseData = [
            "status" => true,
            "url" => "/pages/login.php",
            "message" => "Your profile has been deleted",
        ];

        // Remove active user session
        unset($_SESSION["user"]);
    }
    else {
        $statusCode = "HTTP/1.1 405 Method Not Allowed";
    }
} else {
    $statusCode = "HTTP/1.1 401 Unauthorized";
}
header($statusCode);
echo json_encode($responseData);
exit;

