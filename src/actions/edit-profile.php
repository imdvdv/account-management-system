<?php

include_once __DIR__ . "/../config/includes.php";
include_once __DIR__ . "/../helpers/remove-extra-spaces.php";

session_start();

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

if (isAuthorized()) {

    $userID = $_SESSION["user"]["id"];
    $method = $_SERVER["REQUEST_METHOD"];

    if ($method === "POST") {

        if (isset($_POST["name"], $_POST["email"])) {

            // Validation fields
            $fieldsData = validateFields($_POST); // the function returns array includes prepared value and array of errors

            if (isset($fieldsData["name"], $fieldsData["email"], $fieldsData["errors"]) && empty($fieldsData["errors"])) {

                // Update user data in the database
                $pdo = getPDO();
                $query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
                $values = [$fieldsData["name"], $fieldsData["email"], $userID];
                executeQueryDB($pdo, $query, $values);

                // Prepare a positive response
                $statusCode = "HTTP/1.1 200 OK";
                $responseData = [
                    "status" => true,
                    "message" => "Profile data was changed",
                    "url" => "{$_SERVER['HTTP_REFERER']}", // force reload page to reflect changes
                ];

            } else {
                $responseData["message"] = "Please fill in all fields correctly";
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