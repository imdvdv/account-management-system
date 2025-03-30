<?php

use core\view;
use core\response;
use core\popup;

$fields = [
    ['name' => 'avatar', 'type' => 'file', 'title' => 'Profile photo', 'width' => 70]
];
$errors = response\get_body('errors');
$buttons_data = [
    'items' => [
        ['text' => 'Upload', 'class' => 'form__button form__button_confirm'],
        ['tag' => 'a', 'href' => $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/profile', 'class' => 'form__button form__button_cancel button_cancel']
    ]
];
$form_data = [
    'action' => '/profile/avatar/edit',
    'method' => 'patch',
    'name' => 'form_avatar',
    'enctype' => 'multipart/form-data',
    'class' => 'popup-form',
    'fields' => $fields,
    'errors' => $errors,
    'buttons' => view\template('partials/buttons', $buttons_data)
];
$popup_data = [
    'popup_text' => 'Upload an image. We support JPG, PNG and GIF files.',
    'popup_form' => view\template('partials/form', $form_data)
];
popup\render_popup(content_data: $popup_data);
