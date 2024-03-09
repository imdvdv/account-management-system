<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/includes.php";

function redirectAuthorized (): void {
    if (isAuthorized()){
        header("Location: /pages/profile.php");
        exit;
    }
}

