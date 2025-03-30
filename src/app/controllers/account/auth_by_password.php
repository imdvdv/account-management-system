<?php

use core\controller;
use core\session;
use core\cookie;
use core\response;
use core\helpers;
use app\models\user;
use app\models\auth_token;

$fields = controller\prepare_fields_data(user\LABELS['form_login']);
$errors = user\validate($fields);

if (helpers\has_array_keys($fields, ['email', 'login_password']) && empty($errors)) {
    $user_db = user\get_by_email($fields['email']);

    if (is_array($user_db) && helpers\has_array_keys($user_db, ['id', 'name', 'email', 'password_hash', 'avatar_path'])) {
        $user_id = (int) $user_db['id'];

        if (password_verify($fields['login_password'], $user_db['password_hash'])) {
            $token = helpers\generate_code();
            $expiration_date = time() + ONE_MONTH;
            $db_params = controller\prepare_code_params($user_id, $token, $expiration_date);
            auth_token\store($db_params);

            if (isset($fields['remember']) && $fields['remember'] === 'on') {
                cookie\set('token', $token, $expiration_date);
            }

            session\set_user(id: $user_id, token: $token, email: $user_db['email'], name: $user_db['name'], avatar: $user_db['avatar_path']);
            response\set_body(status: 'success');
            response\redirect('/');
        }

    }

    response\set_body(message: 'Incorrect email or password');
} else {
    response\set_body(message: 'Please fill out the form correctly');
}

response\set_body(status: 'failure', values: $fields, errors: $errors);
response\redirect('/login');