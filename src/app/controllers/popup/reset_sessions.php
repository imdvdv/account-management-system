<?php

use core\view;
use core\popup;

$buttons_data = [
    'items' => [
        ['action' => '/profile/reset-sessions', 'method' => 'delete', 'text' => 'Reset', 'class' => 'popup__button popup__button__reset-sessions'],
        ['tag' => 'a', 'href' => $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/', 'class' => 'button_cancel popup__button popup__button_cancel']
    ]
];
$popup_data = [
    'popup_text' => 'Are you sure you want to end all active sessions, including this one?',
    'popup_buttons' => view\template('partials/buttons', $buttons_data)
];
popup\render_popup('Reset sessions', $popup_data);

