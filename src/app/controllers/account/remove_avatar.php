<?php

use core\response;
use core\session;
use core\helpers;
use app\models\user;

$user_id = session\get_user('id');
$avatar_path = session\get_user('avatar');
$db_params = [
    'avatar' => null,
    'id' => $user_id
];

if (user\update_by_id($db_params)) {

    if (!is_null($avatar_path)) {
        $avatar_path = PUBLIC_DIR . $avatar_path;

        if (!unlink($avatar_path)) {
            helpers\write_to_log("Failed to delete profile avatar {$avatar_path} by user ID {$user_id}", __FILE__);
        }

        session\update_user_data(['avatar' => null]);
    }

}

response\redirect('/');


