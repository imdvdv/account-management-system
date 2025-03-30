<?php

use core\session;
use core\cookie;
use core\response;
use core\helpers;
use app\models\auth_token;
use app\models\user;

if (helpers\is_remembered()) {
    $token = cookie\get('token');
    $token_hash = hash('sha256', $token);
    $token_db = auth_token\get_by_hash($token_hash);
    
    if (isset($token_db['user_id'], $token_db['dt_exp']) && helpers\check_expiration_date($token_db['dt_exp'])) {
        $user_id = (int)$token_db['user_id'];
        $user_db = user\get_by_id($user_id);

        if (is_array($user_db) && helpers\has_array_keys($user_db, ['name', 'email', 'avatar_path'])) {
            cookie\set('token', $token, time() + ONE_MONTH);
            session\set_user(id: $user_id, token: $token, email: $user_db['email'], name: $user_db['name'], avatar: $user_db['avatar_path']); 
            response\redirect('/profile');
        }

    }

    cookie\remove('token');
}

response\redirect();
