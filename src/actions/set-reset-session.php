<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/includes.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/create-reset-code.php";

session_start();

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

//  The action sets up a reset session to change the password
if (isAuthorized()) {
    $userID = $_SESSION["user"]["id"];
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method === "POST"){

        // Set reset session data
        $_SESSION["reset"]["user_id"] = $userID;
        $_SESSION["reset"]["code"] = createResetCode($userID);

        // Prepare a positive response
        $statusCode = "HTTP/1.1 200 OK";
        $responseData = ["status" => true];

    } else {
        $statusCode = "HTTP/1.1 405 Method Not Allowed";
    }
} else {
    $statusCode = "HTTP/1.1 401 Unauthorized";
}
header($statusCode);
echo json_encode($responseData);
exit;