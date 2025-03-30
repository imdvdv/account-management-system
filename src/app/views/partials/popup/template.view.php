<div class="popup">
    <div class="popup__layout">
        <a href="<?= $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/' ?>" class="popup__close"><i
                class="popup__close-icon fa-solid fa-xmark"></i></a>
        <div class="popup__body">
            <h3 class="popup__title"><?= $popup_title ?? '' ?></h3>
            <?= $popup_message_banner ?? '' ?>
            <div class="popup__content">
                <?= $popup_content ?? '' ?>
            </div>
        </div>
    </div>
</div>