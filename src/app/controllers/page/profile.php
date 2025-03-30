<?php

use core\view;
use core\dropdown;
use core\session;

$avatar_path = session\get_user('avatar');

// Prepare dropdown items
$upload_button = ['href' => '/popup/upload-avatar', 'text' => 'Upload photo'];
$dropdown_data['items'][] = $upload_button;

if ($avatar_path !== null) {
    $delete_button = [
        'action' => '/profile/avatar/delete',
        'method' => 'delete',
        'text' => 'Delete photo',
        'color' => '#d93025'
    ];
    $dropdown_data['items'][] = $delete_button;
}

// Prepare profile avatar content
$avatar_data = [
    'path' => $avatar_path,
    'size' => 120,
    'dropdown' => dropdown\get_dropdown_html($dropdown_data)
];
$contents = [
    'avatar' => view\template('partials/avatar', $avatar_data)
];

// Render profile page
view\render_page('profile', array_merge(session\get('user'), $contents));