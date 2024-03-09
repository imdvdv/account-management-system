<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/env.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/validation.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/get-random-code-data.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/create-reset-code.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/send-mail.php";

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

$method = $_SERVER["REQUEST_METHOD"];
if ($method === "POST"){
    if (isset($_POST["email"])) {
        $inputs = [
            "email" => trim($_POST["email"]),
        ];

        // Updating the response in case of validation errors
        $responseData["message"] = "Incorrect email address";
        $responseData = validateFields($inputs, $responseData);

        if (!isset($responseData["errors"])) {

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
            $values = [$inputs["email"]];
            $stmt = executeQueryDB($pdo, $query, $values);

            // Extract user data from the database if the email was found
            if ($stmt->rowCount() > 0) {
                $userID = $stmt->fetchColumn();
                $code = createResetCode($userID); // create reset code for given user

                // Generate and send an email with a link to the password change page using the built-in mail function
                $to = $inputs["email"];
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
        }
    }
} else {
    $statusCode = "HTTP/1.1 405 Method Not Allowed";
}
header($statusCode);
echo json_encode($responseData);