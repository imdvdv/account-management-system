<?php

include_once __DIR__ . "/../src/helpers/redirect-authorized.php";
session_start();
redirectAuthorized();
?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . "/../components/head.html";?>
<body>
<div class="container container_form">
    <h3 class="title">Access recovery</h3>
    <div class="message">
        <p class="message-text"></p>
    </div>
    <form class="form form_recovery" name="form_recovery" id="form_recovery">
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
        <div class="form__options">
            <a href="/pages/login.php" class="form__link">I have a password</a>
        </div>
        <button type="submit" class="form__button form__button_recovery" name="button_recovery">Send Instructions</button>
    </form>
    <div class="redirect">
        <span class="redirect__text">Don't have an account?
            <a href="/pages/signup.php" class="redirect__text-link">Sign Up</a>
        </span>
    </div>
</div>
<?php include_once __DIR__ . "/../components/scripts.html";?>
</body>
</html>