<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/includes.php";

if (isAuthorized()){
    header("Location:/pages/profile.php");
} else {
    header("Location:/pages/login.php");
}
exit;

