<?php

include_once __DIR__ . "/src/config/includes.php";

if (isAuthorized()){
    header("Location:/pages/profile.php");
} else {
    header("Location:/pages/login.php");
}
exit;