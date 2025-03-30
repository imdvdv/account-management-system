<div class="container container_form">
    <h3 class="title">Access recovery</h3>
    <?= $message_banner ?? '' ?>
    <form action="/request-recovery" method="post" name="form_email" class="form form_email">
        <div class="form__field form__field_text <?= isset($errors['email']) ? 'invalid' : '' ?>">
            <div class="form__input-area form__input-area_text">
                <label for="email" class="form__label form__label_text">E-mail *</label>
                <input type="text" class=" form__input form__input_text"
                    value="<?= htmlspecialchars($values['email'] ?? '') ?>" id="email" name="email" autocomplete="off">
            </div>
            <div class="form__error">
                <span class="form__error-text "><?= $errors['email'] ?? '' ?></span>
            </div>
        </div>
        <div class="form__options">
            <button type="submit" class="form__button form__button_forgot button" name="button_forgot">Send
                Instructions</button>
            <a href="/login" class="form__link">I have a password</a>
        </div>
    </form>
    <div class="redirect">
        <span class="redirect__text">Don't have an account?
            <a href="<?= BASE_URL . '/signup"' ?>" class="redirect__link">Sign Up</a>
        </span>
    </div>
</div>