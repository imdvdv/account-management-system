<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/env.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/db-connection.php";

session_start();

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

$method = $_SERVER["REQUEST_METHOD"];
if ($method === "POST"){

    // Remove user auth token from cookies and from the database if it exists
    if (isset($_COOKIE["token"]) && !empty($_COOKIE["token"])) {
        $token = $_COOKIE["token"];
        $tokenHash = hash("sha256", $token); // token hashing

        // Delete a row with the matching token hash from the database
        $pdo = getPDO();
        $query = "DELETE FROM auth_tokens WHERE token_hash = ? LIMIT 1";
        $values = [$tokenHash];
        executeQueryDB($pdo, $query, $values);

        setcookie("token", "", time() - ONE_HOUR, "/"); // clear token cookie
    }

    // Clear current user session
    setcookie("PHPSESSID", "", time() - ONE_HOUR, "/");
    session_unset();
    session_destroy();

    // Prepare a positive response
    $responseData = [
        "status" => true,
        "url" => "/pages/login.php",
    ];
} else {
    $statusCode = "HTTP/1.1 405 Method Not Allowed";
}
header($statusCode);
echo json_encode($responseData);
exit;


