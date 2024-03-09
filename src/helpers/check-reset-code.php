<?php

function checkResetCode (string $code): bool {

    if (validateCode($code)){

        // Check the code hash exists in the database
        $codeHash = hash("sha256", $code); // hashing the code
        $pdo = getPDO();
        $query = "SELECT * FROM reset_codes WHERE code_hash = ? LIMIT 1";
        $values = [$codeHash];
        $stmt = executeQueryDB($pdo, $query, $values);

        // if the code hashes match, extract the code data from the database
        if ($stmt->rowCount() == 1) {
            $dataDB = $stmt->fetch();
            $codeID = $dataDB["id"];
            $codeExpiryDB = $dataDB["code_expiry"];
            $userID = $dataDB["user_id"];

            // Check code expiration time
            if (strtotime($codeExpiryDB) <= time()) {
                $query = "DELETE FROM reset_codes WHERE id = ? LIMIT 1";
                $values = [$codeID];
                executeQueryDB($pdo, $query, $values); // delete expire code data from the database
            } else {

                // Set session with the reset code for using in passwordUpdate function
                $_SESSION["reset"] = [
                    "code" => $code,
                    "user_id" => $userID,
                ];
                session_regenerate_id();
                return true;
            }
        }
    }
    return false;
}