<?php

// For creating user auth token and password reset code
function getRandomCodeData (int|null $expirationDate = null): array{
    $code = bin2hex(random_bytes(16));
    $codeHash = hash("sha256", $code);
    $codeData =  [
        "code" => $code,
        "codeHash" => $codeHash,
    ];
    if ($expirationDate) {
        $codeExpiry = date("Y-m-d H:i:s", time() + $expirationDate); // set expiration time for code
        $codeData["codeExpiry"] = $codeExpiry;
    }
    return $codeData;
}