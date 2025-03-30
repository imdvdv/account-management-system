<div class="container container_form">
    <h3 class="title">Create a new password</h3>
    <?= $message_banner ?? '' ?>
    <form action="/profile/recovery-access" method="post" class="form form_recovery" name="form_recovery">
        <input type="hidden" name="_method" value="patch">
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
        <button type="submit" class="form__button form__button_recovery button">Submit</button>
    </form>
    <div class="redirect">
        <a href="<?= BASE_URL . '/' ?>" class="redirect__link">Home</a>
    </div>
</div>