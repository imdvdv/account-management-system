<form action="<?= $action ?? '' ?>" method="post" name="<?= $name ?? 'form' ?>"
    class="form <?= $name ?? '' ?> <?= $class ?? '' ?>"
    enctype="<?= $enctype ?? 'application/x-www-form-urlencoded' ?>">
    <input type="hidden" name="_method" value="<?= $method ?? 'post' ?>">

    <?php foreach ($fields as $field):

        if (isset($field['type'])): ?>

            <div class="form__field form__field_<?= $field['type'] ?><?= isset($errors[$field['name']]) ? ' invalid' : '' ?>"
                style="max-width: <?= $field['width'] ?? '100' ?>%">
                <div class="form__input-area form__input-area_<?= $field['type'] ?>">

                    <?php if ($field['type'] == 'checkbox'): ?>

                        <input type="<?= $field['type'] ?>" class="form__input form__input_<?= $field['type'] ?>"
                            name="<?= $field['name'] ?? '' ?>" id="<?= $field['id'] ?? $field['name'] ?? '' ?>">
                        <label for="<?= $field['id'] ?? $field['name'] ?? '' ?>"
                            class="form__label form__label_<?= $field['type'] ?>"><?= $field['title'] ?? '' ?></label>

                    <?php else: ?>

                        <label for="<?= $field['id'] ?? $field['name'] ?? '' ?>"
                            class="form__label form__label_<?= $field['type'] ?>"><?= $field['title'] ?? '' ?></label>
                        <input type="<?= $field['type'] ?? 'text' ?>" class="form__input form__input_<?= $field['type'] ?>"
                            value="<?= htmlspecialchars($values[$field['name']] ?? $field['value'] ?? '') ?>"
                            id="<?= $field['id'] ?? $field['name'] ?? '' ?>" name="<?= $field['name'] ?? '' ?>"
                            placeholder="<?= $field['placeholder'] ?? '' ?>" autocomplete="<?= $field['autocomplete'] ?? 'off' ?>">

                    <?php endif; ?>

                </div>
                <div class="form__error">
                    <span class="form__error-text"><?= $errors[$field['name']] ?? '' ?></span>
                </div>
            </div>

        <?php endif;

    endforeach;

    echo $buttons ?? '<button type="submit" class="button form__button' . ($button['class'] ?? '') . '">' . ($button['text'] ?? 'Submit') . '</button>'; ?>
</form>