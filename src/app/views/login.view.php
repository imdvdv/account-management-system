<div class="container container_form">
    <h3 class="title">Log In</h3>
    <?= $message_banner ?? '' ?>
    <form action="/auth" method="post" name="form_login" class="form form_login">
        <div class="form__field form__field_text <?= isset($errors['email']) ? 'invalid' : '' ?>">
            <div class="form__input-area form__input-area_text">
                <label for="email" class="form__label form__label_text">E-mail *</label>
                <input type="text" class="form__input form__input_text"
                    value="<?= htmlspecialchars($values['email'] ?? '') ?>" id="email" name="email" autocomplete="off">
            </div>
            <div class="form__error">
                <span class="form__error-text "><?= $errors['email'] ?? '' ?></span>
            </div>
        </div>
        <div class="form__field form__field_password <?= isset($errors['login_password']) ? 'invalid' : '' ?>">
            <div class="form__input-area form__input-area_password">
                <label for="password" class="form__label form__label_password">Password *</label>
                <input type="password" class="form__input form__input_password"
                    value="<?= htmlspecialchars($values['login_password'] ?? '') ?>" id="login_password"
                    name="login_password" autocomplete="off">
                <i class="form__input-icon form__input-icon_eye fa-solid fa-eye-slash"></i>
            </div>
            <div class="form__error">
                <span class="form__error-text "><?= $errors['login_password'] ?? '' ?></span>
            </div>
        </div>
        <div class="form__options">
            <div class="form__field form__field_checkbox">
                <div class="form__input-area form__input-area_checkbox">
                    <input type="checkbox" class="form__input form__input_checkbox" name="remember" id="remember">
                    <label for="remember" class="form__label form__label_checkbox">Remember me</label>
                </div>
            </div>
            <a href="<?= BASE_URL . '/forgot' ?>" class="form__link">Forgot password?</a>
        </div>
        <button type="submit" class="form__button form__button_login button">Sign In</button>
    </form>
    <div class="redirect">
        <span class="redirect__text">Don't have an account?
            <a href="/signup" class="redirect__link">Sign Up</a>
        </span>
    </div>
</div>