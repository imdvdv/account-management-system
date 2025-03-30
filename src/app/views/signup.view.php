<div class="container container_form">
    <h3 class="title">Registration</h3>
    <?= $message_banner ?? '' ?>
    <form action="/register" method="post" name="form_signup" class="form form_signup">
        <div class="form__field form__field_text <?= isset($errors['name']) ? 'invalid' : '' ?>">
            <div class="form__input-area form__input-area_text">
                <label for="name" class="form__label form__label_text">Name</label>
                <input type="text" class="form__input form__input_text"
                    value="<?= htmlspecialchars($values['name'] ?? '') ?>" id="name" name="name" autocomplete="off">
            </div>
            <div class="form__error">
                <span class="form__error-text"><?= $errors['name'] ?? '' ?></span>
            </div>
        </div>
        <div class="form__field form__field_text <?= isset($errors['email']) ? 'invalid' : '' ?>">
            <div class="form__input-area form__input-area_text">
                <label for="email" class="form__label form__label_text">E-mail *</label>
                <input type="text" class="form__input form__input_text"
                    value="<?= htmlspecialchars($values['email'] ?? ''); ?>" id="email" name="email" autocomplete="off">
            </div>
            <div class="form__error">
                <span class="form__error-text"><?= $errors['email'] ?? '' ?></span>
            </div>
        </div>
        <div class="form__field form__field_password <?= isset($errors['password']) ? 'invalid' : '' ?>">
            <div class="form__input-area form__input-area_password">
                <label for="password" class="form__label form__label_password">Password *</label>
                <input type="password" class="form__input form__input_password"
                    value="<?= htmlspecialchars($values['password'] ?? '') ?>" id="password" name="password"
                    autocomplete="off">
                <i class="form__input-icon form__input-icon_eye fa-solid fa-eye-slash"></i>
            </div>
            <div class="form__error">
                <span class="form__error-text "><?= $errors['password'] ?? '' ?></span>
            </div>
        </div>
        <div class="form__field form__field_password <?= isset($errors['confirm_password']) ? 'invalid' : '' ?>">
            <div class="form__input-area form__input-area_password">
                <label for="confirm_password" class="form__label form__label_password">Confirm password *</label>
                <input type="password" class="form__input form__input_password"
                    value="<?= htmlspecialchars($values['confirm_password'] ?? '') ?>" id="confirm_password"
                    name="confirm_password" autocomplete="off">
                <i class="form__input-icon form__input-icon_eye fa-solid fa-eye-slash"></i>
            </div>
            <div class="form__error">
                <span class="form__error-text "><?= $errors['confirm_password'] ?? '' ?></span>
            </div>
        </div>
        <button type="submit" class="form__button form__button_signup button">Sign Up</button>
    </form>
    <div class="redirect">
        <span class="redirect__text">Already have an account?
            <a href="<?= BASE_URL . '/login' ?>" class="redirect__link">Log In</a>
        </span>
    </div>
</div>