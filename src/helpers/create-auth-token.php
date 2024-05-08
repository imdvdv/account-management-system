<?php

function createAuthToken (int $userID): string {

    // Create user auth token data
    $tokenData = getRandomCodeData (ONE_WEEK);
    $token = $tokenData["code"];
    $tokenHash = $tokenData["codeHash"];
    $tokenExpiry = $tokenData["codeExpiry"];

    // Write token values to the database
    $pdo = getPDO();
    $query = "INSERT INTO auth_tokens (user_id, token_hash, token_expiry)
    VALUES(?,?,?)";
    $values = [$userID, $tokenHash, $tokenExpiry];
    executeQuery($pdo, $query, $values);

    return $token;
}