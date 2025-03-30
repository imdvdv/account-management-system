<?php

use core\db;
use core\session;
use core\helpers;
use core\response;
use app\models\user;

$user_id = session\get_user('id');
$avatar_path = session\get_user('avatar');

if (user\remove_by_id($user_id)) {

    if (!is_null($avatar_path)) {
        $avatar_path = PUBLIC_DIR . $avatar_path;

        if (!unlink($avatar_path)) {
            helpers\write_to_log("Failed to delete profile avatar $avatar_path from uploads by user ID $user_id", __FILE__);
        }

    }

    session\remove('user');
    response\set_body(status: 'success', message: 'Your profile has been deleted');
} else {
    db\roll_back();
    helpers\write_to_log("Failed to delete user data by user ID {$user_id}", __FILE__);
    response\set_body(status: 'failure', message: 'Failed to delete profile. Try again later.');
}

response\redirect('/');

