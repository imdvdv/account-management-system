<?php

use core\view;
use core\popup;

$buttons_data = [
    'items' => [
        ['action' => 'profile/delete', 'method' => 'delete', 'text' => 'Delete', 'class' => 'button_delete popup__button popup__button_delete'],
        ['tag' => 'a', 'href' => $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/', 'class' => 'button_cancel popup__button popup__button_cancel']
    ]
];
$popup_data = [
    'popup_text' => 'Are you sure you want to delete your profile?',
    'popup_buttons' => view\template('partials/buttons', $buttons_data)
];
popup\render_popup('Delete profile', $popup_data);

