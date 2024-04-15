<?php

include_once __DIR__ . "/../config/includes.php";
include_once __DIR__ . "/../helpers/create-auth-token.php";

session_start();

// Prepare a preliminary negative response in case of errors
$statusCode = "HTTP/1.1 400 Bad Request";
$responseData = ["status" => false];

$method = $_SERVER["REQUEST_METHOD"];
if ($method === "POST"){
    if (isset($_POST["email"], $_POST["password"])) {
        $inputs = [
            "email" => trim($_POST["email"]),
            "password" => trim($_POST["password"]),
        ];

        // Updating the response in case of validation errors
        $responseData["message"] = "Please fill in all fields correctly";
        $responseData = validateFields($inputs, $responseData,  VALIDATION_PARAMS["login_fields"]);

        if (!isset($responseData["errors"])) {

            $responseData["message"] = "Incorrect email or password"; // response message in case user's email or password is incorrect

            // Query the database for a row with matching the email
            $pdo = getPDO();
            $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
            $values = [$inputs["email"]];
            $stmt = executeQueryDB($pdo, $query, $values);

            // Extract user data from the database if the email was found
            if ($stmt->rowCount() == 1) {
                $dataDB = $stmt->fetch();
                $emailDB = $dataDB["email"];
                $passwordDB = $dataDB["password_hash"];
                $userID = $dataDB["id"];

                // Verification of the input password and the password from the database
                if (password_verify($inputs["password"], $passwordDB)) {

                    // Prepare a positive response
                    $statusCode = "HTTP/1.1 200 OK";
                    $responseData = [
                        "status" => true,
                        "url" => "/pages/profile.php",
                    ];

                    // If checkbox "remember me" was clicked set cookie with the auth token for a week
                    if (isset($_POST["remember"]) && $_POST["remember"] == "on"){
                        $token = createAuthToken ($userID);
                        setcookie("token", $token, time() + ONE_WEEK, "/", "", true, true);
                    }

                    // Set user sessions
                    $_SESSION["user"]["id"] = $userID;
                    session_regenerate_id();
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