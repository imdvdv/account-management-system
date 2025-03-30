<div class="message-banner <?= $status ?? ''; ?>">
    <?php if ($close_btn): ?>
        <button class="message-banner__close" type="button"><i class="fa-solid fa-xmark"></i></button>
    <?php endif ?>
    <p class="message-banner__text"><?= $text ?? ''; ?></p>
</div>