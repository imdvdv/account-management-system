span<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/env.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/validation.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/check-reset-code.php";
session_start();

if (isset($_GET["code"]) && !empty($_GET["code"]) && checkResetCode($_GET["code"])) {
?>
<!DOCTYPE html>
<html>
<?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/head.html";?>
<body>
<div class="container container_form">
    <h3 class="title">Create a new password</h3>
    <div class="message">
        <p class="message-text"></p>
    </div>
    <form class="form form_change-password" name="form_change-password" id="form_change-password">
        <div class="form__field form__field_password">
            <div class="form__input form__input_password">
                <label for="password" class="form__label">Password*</label>
                <input type="password" class="form__input-value" id="password" name="password" autocomplete="off"">
                <i class="form__input-icon form__input-icon_eye fa-solid fa-eye-slash"></i>
            </div>
            <div class="form__error form__error_password">
                <i class="form__error-icon form__error-icon_password fa-solid fa-circle-exclamation"></i>
                <span class="form__error-text form__error-text_password"></span>
            </div>
        </div>
        <button type="submit" class="form__button form__button_change-password" name="button_change-password">Change</button>
    </form>
    <div class="redirect redirect_change-password">
        <a href="/pages/profile.php" class="redirect__link">Home</a>
    </div>
</div>
<?php include_once "{$_SERVER["DOCUMENT_ROOT"]}/components/scripts.html";?>
</body>
</html>
<?php
} else {
    $_SESSION["message"] = "Link incorrect or expire";
    include_once "{$_SERVER["DOCUMENT_ROOT"]}/pages/404.php";
} ?>