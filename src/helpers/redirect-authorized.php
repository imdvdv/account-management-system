<?php

include_once __DIR__ . "/../config/includes.php";

function redirectAuthorized (): void {
    if (isAuthorized()){
        header("Location: /pages/profile.php");
        exit;
    }
}

