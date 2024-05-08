<?php

function updateAvatar (int $userID, array $file = null): bool {

    // If the function was not passed a file, it deletes the current profile image if it exists
    if ($file){
        $avatarPath = fileUpload($file, "avatars");
        if (!$avatarPath) {
            return false;
        }
    } else {
        $avatarPath = null;
    }

    // Delete the avatar file from the uploads directory if it exists
    $pdo = getPDO();
    $query = "SELECT avatar_path FROM users WHERE id = ? LIMIT 1";
    $values = [$userID];
    $stmt = executeQuery($pdo, $query, $values);

    if ($stmt->columnCount() > 0){
        $avatarPathDB = $stmt->fetchColumn(); // extract user avatar path from the database
        if ($avatarPathDB) {
            unlink("{$_SERVER["DOCUMENT_ROOT"]}$avatarPathDB"); // delete avatar file
        }
    }

    // Update avatar path in the users table for a given user ID
    $query = "UPDATE users SET avatar_path = ? WHERE id = ?";
    $values = [$avatarPath, $userID];
    executeQuery($pdo, $query, $values);

    return true;
}