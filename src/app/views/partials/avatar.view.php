<div class="avatar">
    <div class="avatar__content">
        <img class="avatar__image" src="<?= BASE_URL . ($path ?? DEFAULT_USER_AVATAR); ?>" width="<?=$size?>px" height="<?=$size?>px" alt="avatar">
        <?= $dropdown ?? ''; ?>
    </div>
</div>