<?php

include_once __DIR__ . "/../config/env.php";
include_once __DIR__ . "/../helpers/db-connection.php";
include_once __DIR__ . "/../helpers/validation.php";
include_once __DIR__ . "/../helpers/remove-extra-spaces.php";

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST"){

    if (isset($_POST["name"], $_POST["email"], $_POST["password"])) {

        $responseData["message"] = "Please fill in all fields correctly"; // updating the response in case of validation errors

        $fieldsData = validateFields($_POST); // the function returns array includes prepared value and array of errors

        if (isset($fieldsData["email"]) && !isset($fieldsData["errors"]["email"])) {

            // Check the email exists in the database
            $pdo = getPDO();
            $query = "SELECT email FROM users WHERE email = ? LIMIT 1";
            $values = [$fieldsData["email"]];
            $stmt = executeQuery($pdo, $query, $values);

            if ($stmt->rowCount() > 0) {
                $responseData["errors"]["email"] = "this email already exists";

            } elseif (isset($fieldsData["name"], $fieldsData["password"], $fieldsData["errors"]) && empty($fieldsData["errors"])) {

                // Write user data to the database
                $passwordHash = password_hash($fieldsData["password"], PASSWORD_DEFAULT);
                $query = "INSERT INTO users (`name`, `email`, `password_hash`)
                VALUES(?,?,?)";
                $values = [$fieldsData["name"], $fieldsData["email"], $passwordHash];
                executeQuery($pdo, $query, $values);

                // Prepare a positive response
                $statusCode = "HTTP/1.1 201 Created";
                $responseData = [
                    "status" => true,
                    "message" => "Your account has been created successfully!",
                    "url" => "/pages/login.php",
                ];
            }
        }
    }

} else {
    $statusCode = "HTTP/1.1 405 Method Not Allowed";
}

header($statusCode);
echo json_encode($responseData);
exit;
