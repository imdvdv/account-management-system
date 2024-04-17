<?php

function isAuthorized (): bool {
    if (isset($_SESSION["user"]["id"]) && is_numeric($_SESSION["user"]["id"])) {
        return true;
    } elseif (isset($_COOKIE["token"]) && !empty($_COOKIE["token"])){
        $token = $_COOKIE["token"];
        return authByToken($token);
    }
    return false;
}