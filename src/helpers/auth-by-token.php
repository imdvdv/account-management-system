<?php

function authByToken (string $token): bool {

    if (validateCode($token)) {

        // Query the database for a row with matching token hash if it exists
        $tokenHash = hash("sha256", $token);
        $pdo = getPDO();
        $query = "SELECT * FROM auth_tokens WHERE token_hash = ? LIMIT 1";
        $values = [$tokenHash];
        $stmt = executeQuery($pdo, $query, $values);

        // Extract token data from the database if the token hash was found
        if ($stmt->rowCount() == 1) {
            $dataDB = $stmt->fetch();
            $userID = $dataDB["user_id"];
            $tokenID = $dataDB["id"];
            $tokenExpiry = $dataDB["token_expiry"];

            // Check the token expiration time
            if (strtotime($tokenExpiry) <= time()) {
                $query = "DELETE FROM auth_tokens WHERE id = ?";
                $values = [$tokenID];
                executeQuery($pdo, $query, $values); // delete an expired token from the database
            } else {

                // Update auth token data
                $newTokenData = getRandomCodeData(ONE_WEEK);
                $newToken = $newTokenData["code"];
                $newTokenHash = $newTokenData["codeHash"];
                $newTokenExpiry = $newTokenData["codeExpiry"];
                $query = "UPDATE auth_tokens SET token_hash = ?, token_expiry = ? WHERE id = ?";
                $values = [$newTokenHash, $newTokenExpiry, $tokenID];
                executeQuery($pdo, $query, $values);

                setcookie("token", $newToken, time() + ONE_WEEK, "/", "", true, true);// refresh the token cookie

                // Set user session
                $_SESSION["user"]["id"] = $userID;
                session_regenerate_id();

                return true;
            }
        }
    }
    setcookie("token", "", time() - ONE_WEEK, "/"); // remove the token cookie
    return false;
}

