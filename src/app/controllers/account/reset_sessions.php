<?php

use core\session;
use core\cookie;
use core\response;
use core\helpers;
use app\models\auth_token;

$user_id = session\get_user('id');

if (auth_token\remove_by_user_id($user_id)) {
    session\remove('user');

    if (cookie\has('token')) {
        cookie\remove('token');
    }

    response\set_body(status: 'success', message: 'All your active sessions have been deleted');
} else {
    helpers\write_to_log("Failed to delete active sessions by user ID {$user_id}", __FILE__);
    response\set_body(status: 'failure', message: 'Failed to delete sessions. Try again later.');
}

response\redirect('/');