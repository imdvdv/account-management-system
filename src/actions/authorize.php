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
        $inputData = $_POST;

        // Validation fields
        $fieldsData = validateFields($inputData,  VALIDATION_PARAMS["login_fields"]); // the function returns array includes prepared value and array of errors

        if (isset($fieldsData["email"], $fieldsData["password"], $fieldsData["errors"]) && empty($fieldsData["errors"])) {

            $responseData["message"] = "Incorrect email or password"; // response message in case user's email or password is incorrect

            // Query the database for a row with matching the email
            $pdo = getPDO();
            $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
            $values = [$fieldsData["email"]];
            $stmt = executeQueryDB($pdo, $query, $values);

            // Extract user data from the database if the email was found
            if ($stmt->rowCount() == 1) {
                $dataDB = $stmt->fetch();
                $emailDB = $dataDB["email"];
                $passwordDB = $dataDB["password_hash"];
                $userID = $dataDB["id"];

                // Verification of the input password and the password from the database
                if (password_verify($fieldsData["password"], $passwordDB)) {

                    // Prepare a positive response
                    $statusCode = "HTTP/1.1 200 OK";
                    $responseData = [
                        "status" => true,
                        "url" => "/pages/profile.php",
                    ];

                    // If checkbox "remember me" was clicked set cookie with the auth token for a week
                    if (isset($inputData["remember"]) && $inputData["remember"] == "on"){
                        $token = createAuthToken ($userID);
                        setcookie("token", $token, time() + ONE_WEEK, "/", "", true, true);
                    }

                    // Set user sessions
                    $_SESSION["user"]["id"] = $userID;
                    session_regenerate_id();
                }
            }
        } else{
            $responseData["message"] = "Please fill in all fields correctly";
        }
    }
} else {
    $statusCode = "HTTP/1.1 405 Method Not Allowed";
}
header($statusCode);
echo json_encode($responseData);
exit;