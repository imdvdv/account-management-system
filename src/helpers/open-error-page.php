<?php

function openErrorPage(int $code = 404, string $errorMessage = "404 - Not Found"): void {

    http_response_code($code);
    $_SESSION["message"] = $errorMessage;
    header("Content-type: text/html; charset=UTF-8");
    include_once __DIR__ . "/../../pages/error-page.php";

}