<?php

function createResetCode (int $userID): string{

    // Create a reset code data to change password
    $codeData = getRandomCodeData (ONE_HOUR);
    $code = $codeData["code"];
    $codeHash = $codeData["codeHash"];
    $codeExpiry = $codeData["codeExpiry"];

    // Check the reset code exists in the database for this user ID
    $pdo = getPDO();
    $query = "SELECT * FROM reset_codes WHERE user_id = ? LIMIT 1";
    $values = [$userID];
    $stmt = executeQueryDB($pdo, $query, $values);

    // If there is already a reset code row for a given user in the database, overwrite it with a new one
    if ($stmt->rowCount() == 1){
        $query = "UPDATE reset_codes SET code_hash = ?, code_expiry = ? WHERE user_id = ?";
        $values = [$codeHash, $codeExpiry, $userID];
    } else {
        $query = "INSERT INTO reset_codes (user_id, code_hash, code_expiry)
        VALUES(?,?,?)";
        $values = [$userID, $codeHash, $codeExpiry];
    }
    executeQueryDB($pdo, $query, $values);
    return $code;
}