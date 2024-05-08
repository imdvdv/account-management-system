<?php

include_once __DIR__ . "/../config/env.php";
include_once __DIR__ . "/../helpers/db-connection.php";
include_once __DIR__ . "/../helpers/validation.php";
include_once __DIR__ . "/../helpers/check-reset-code.php";
session_start();

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST"){

    if (isset($_POST["password"], $_SESSION["reset"]["code"]) && !empty($_SESSION["reset"]["code"])) {
        $resetCode = $_SESSION["reset"]["code"];
        if (checkResetCode($resetCode)) {

            // Check for a session with password reset data. This should have been set by the checkResetCode function
            if (isset($_SESSION["reset"]["user_id"]) && is_numeric($_SESSION["reset"]["user_id"])) {

                $userID = $_SESSION["reset"]["user_id"];
                
                // Validation field
                $fieldsData = validateFields($_POST); // the function returns array includes prepared value and array of errors

                if (isset($fieldsData["password"], $fieldsData["errors"]) && empty($fieldsData["errors"])) {

                    // Prepare a positive response
                    $statusCode = "HTTP/1.1 200 OK";
                    $responseData = [
                        "status" => true,
                        "message" => "Your password has been successfully changed!",
                    ];

                    // Update the password hash in the database
                    $pdo = getPDO();
                    $passwordHash = password_hash($fieldsData["password"], PASSWORD_DEFAULT);
                    $query = "UPDATE users SET password_hash = ? WHERE id = ?";
                    $values = [$passwordHash, $userID];
                    executeQuery($pdo, $query, $values);

                    // Delete all active sessions and their tokens except the current one if it exists
                    if (isset($_COOKIE["token"]) && !empty($_COOKIE["token"])) {

                        $token = $_COOKIE["token"];
                        $tokenHash = hash("sha256", $token);
                        $query = "DELETE FROM auth_tokens WHERE user_id = ? AND NOT token_hash = ?";
                        $values = [$userID, $tokenHash];
                        executeQuery($pdo, $query, $values);
                        $responseData["url"] = "/pages/profile.php"; // updating response url for redirect after function completion

                    } else {

                        $query = "DELETE FROM auth_tokens WHERE user_id = ?";
                        $values = [$userID];
                        executeQuery($pdo, $query, $values);
                        $responseData["url"] = "/pages/login.php";

                    }

                    // Delete data from the reset_codes table for the current user ID
                    $query = "DELETE FROM reset_codes WHERE user_id = ?";
                    $values = [$userID];
                    executeQuery($pdo, $query, $values);

                    unset($_SESSION["reset"]); // remove the reset session

                } else {
                    $responseData["message"] = "Please fill in the field correctly";
                }
            }
        }
    }
} else {
    $statusCode = "HTTP/1.1 405 Method Not Allowed";
}
header($statusCode);
echo json_encode($responseData);
exit;