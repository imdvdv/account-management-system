<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/redirect-authorized.php";
session_start();
redirectAuthorized();
?>
<!DOCTYPE html>
<html>
<?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/head.html";?>
<body>
<div class="container container_form">
    <h3 class="title">Log In</h3>
    <div class="message">
        <p class="message-text"></p>
    </div>
    <form name="form_login" class="form form_login" id="form_login">
        <div class="form__field form__field_email">
            <div class="form__input form__input_email">
                <label for="email" class="form__label">E-mail*</label>
                <input type="text" class="form__input-value" id="email" name="email" autocomplete="off">
            </div>
            <div class="form__error form__error_email">
                <i class="form__error-icon form__error-icon_email fa-solid fa-circle-exclamation"></i>
                <span class="form__error-text form__error-text_email"></span>
            </div>
        </div>
        <div class="form__field form__field_password">
            <div class="form__input form__input_password">
                <label for="password" class="form__label">Password*</label>
                <input type="password" class="form__input-value" id="password" name="password" autocomplete="off">
                <i class="form__input-icon form__input-icon_eye fa-solid fa-eye-slash"></i>
            </div>
            <div class="form__error form__error_password">
                <i class="form__error-icon form__error-icon_password fa-solid fa-circle-exclamation"></i>
                <span class="form__error-text form__error-text_password"></span>
            </div>
        </div>
        <div class="form__options">
            <div class="form__checkbox">
                <input type="checkbox" class="form__checkbox-value" id="remember" name="remember">
                <label for="remember" class="form__checkbox-label">Remember me</label>
            </div>
            <a href="/pages/recovery.php" class="form__link">Forgot password?</a>
        </div>
        <button type="submit" class="form__button form__button_login" name="button_login">Sign In</button>
    </form>
    <div class="redirect">
        <span class="redirect__text">Don't have an account?
            <a href="/pages/signup.php" class="redirect__text-link">Sign Up</a>
        </span>
    </div>
</div>
<?php include_once "{$_SERVER["DOCUMENT_ROOT"]}/components/scripts.html";?>
</body>
</html>