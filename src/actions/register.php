<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/env.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/validation.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/remove-extra-spaces.php";

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

$method = $_SERVER["REQUEST_METHOD"];
if ($method === "POST"){
    if (isset($_POST["name"], $_POST["email"], $_POST["password"])) {
        $inputs = [
            "name" => trim(removeExtraSpaces($_POST["name"])),
            "email" => trim($_POST["email"]),
            "password" => trim($_POST["password"]),
        ];

        // Updating the response in case of validation errors
        $responseData["message"] = "Please fill in all fields correctly";
        $responseData = validateFields($inputs, $responseData);

        if (!isset($responseData["errors"]["email"])) {

            // Check the email exists in the database
            $pdo = getPDO();
            $query = "SELECT email FROM users WHERE email = ? LIMIT 1";
            $values = [$inputs["email"]];
            $stmt = executeQueryDB($pdo, $query, $values);

            if ($stmt->rowCount() > 0) {
                $responseData["errors"]["email"] = "this email already exists";

            } elseif (!isset($responseData["errors"]["password"])) {

                // Write user data to the database
                $passwordHash = password_hash($inputs["password"], PASSWORD_DEFAULT);
                $query = "INSERT INTO users (name, email, password_hash)
                VALUES(?,?,?)";
                $values = [$inputs["name"], $inputs["email"], $passwordHash];
                executeQueryDB($pdo, $query, $values);

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
