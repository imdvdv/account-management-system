<?php

include_once __DIR__ . "/../config/env.php";
include_once __DIR__ . "/../helpers/db-connection.php";
include_once __DIR__ . "/../helpers/validation.php";
include_once __DIR__ . "/../helpers/get-random-code-data.php";
include_once __DIR__ . "/../helpers/create-reset-code.php";
include_once __DIR__ . "/../helpers/send-mail.php";

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST"){

    if (isset($_POST["email"])) {

        // Validation field
        $fieldsData = validateFields($_POST); // the function returns array includes prepared value and array of errors

        if (isset($fieldsData["email"], $fieldsData["errors"]) && empty($fieldsData["errors"])) {

            // Prepare a positive response (report successful sending even if the email address was not found in the database)
            $statusCode = "HTTP/1.1 200 OK";
            $responseData = [
                "status" => true,
                "url" => "/pages/login.php",
                "message" => "An email with instructions was sent to the specified address",
            ];

            // Query the database for a row with the matching email
            $pdo = getPDO();
            $query = "SELECT id FROM users WHERE email = ? LIMIT 1";
            $values = [$fieldsData["email"]];
            $stmt = executeQuery($pdo, $query, $values);

            // Extract user data from the database if the email was found
            if ($stmt->rowCount() > 0) {
                $userID = $stmt->fetchColumn();
                $code = createResetCode($userID); // create reset code for given user

                // Generate and send an email with a link to the password change page using the built-in mail function
                $to = $fieldsData["email"];
                $subject = "Password recovery";
                $message = 'To reset a password and create new - <a href="http://{YOUR_DOMAIN}/pages/change-password.php?code='.$code.'">click here</a>. </br>Reset your password in a hour.';

                if (!sendMail($to, $subject, $message)){

                    // Prepare a negative response in case the mail function does not generate the letter
                    $responseData = [
                        "status" => false,
                        "message" => "The email could not be sent due to technical reasons. Please try again later",
                    ];
                }
            }
        } else {
            $responseData["message"] = "Incorrect email address";
        }
    }
} else {
    $statusCode = "HTTP/1.1 405 Method Not Allowed";
}
header($statusCode);
echo json_encode($responseData);