<div class="container container_profile">
    <h3 class="title">Profile</h3>
    <?= $message_banner ?? '' ?>
    <div class="profile profile_editor">
        <div class="profile__layout">
            <?= $avatar ?? '' ?>
            <form action="/profile/edit" method="post" name="form_profile" class="form form_profile">
                <input type="hidden" name="_method" value="patch">
                <div class="form__field form__field_text <?= isset($errors['name']) ? 'invalid' : '' ?>">
                    <div class="form__input-area form__input-area_text profile-field">
                        <label for="name" class="form__label form__label_text">Name</label>
                        <input type="text" class="form__input form__input_text"
                            value="<?= htmlspecialchars($values['name'] ?? $name ?? '') ?>" id="name" name="name"
                            autocomplete="off">
                    </div>
                    <div class="form__error">
                        <span class="form__error-text "><?= $errors['name'] ?? '' ?></span>
                    </div>
                </div>
                <div class="form__field form__field_text <?= isset($errors['email']) ? 'invalid' : '' ?>">
                    <div class="form__input-area form__input-area_text profile-field">
                        <label for="email" class="form__label form__label_text">E-mail</label>
                        <input type="text" class="form__input form__input_text"
                            value="<?= htmlspecialchars($values['email'] ?? $email ?? '') ?>" id="email" name="email"
                            autocomplete="off">
                    </div>
                    <div class="form__error">
                        <span class="form__error-text "><?= $errors['email'] ?? '' ?></span>
                    </div>
                </div>
                <button type="submit" class="form__button form__button_editor button">Save</button>
            </form>
            <div class="profile__options">
                <form action="/request-recovery" class="profile__action" method="post">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <button type="submit" class="profile__link profile__link_change-password">
                        <i class="fa-solid fa-pen-to-square"></i> Change password
                    </button>
                </form>
                <a href="/popup/reset-sessions" class="profile__link profile__link_reset-sessions"><i
                        class="fa-solid fa-users-slash"></i> Reset all sessions</a>
                <form action="/logout" class="profile__action profile__action_logout" method="post">
                    <input type="hidden" name="_method" value="delete">
                    <button role="submit" class="profile__button profile__button_logout button">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </form>
                <a href="/popup/delete-profile" class="profile__link profile__link_delete-profile"><i
                        class="fa-solid fa-trash"></i> Delete profile</a>
            </div>
        </div>
    </div>
</div>
<?= $popup ?? '' ?>