<?php

use core\controller;
use core\helpers;
use core\response;
use app\models\user;

$fields = controller\prepare_fields_data(user\LABELS['form_signup']);
$errors = user\validate($fields);

if (is_array($fields) && helpers\has_array_keys($fields, ['name', 'email', 'password', 'confirm_password'])) {

    if (!isset($errors['email'])) {
        $user_db = user\get_by_email($fields['email']);

        if (is_array($user_db) && isset($user_db['email'])) {
            $errors['email'] = 'this email already exists';
        }
    }

    if (!isset($errors['password']) && !isset($errors['confirm_password']) && $fields['password'] !== $fields['confirm_password']) {
        $errors['confirm_password'] = 'passwords must match';
    }

    if (empty($errors)) {
        $db_params = [
            'name' => $fields['name'],
            'email' => $fields['email'],
            'hash' => password_hash($fields['password'], PASSWORD_DEFAULT),
        ];

        if (user\store($db_params)) {
            response\set_body(status: 'success', message: 'Your account has been successfully created');
            response\redirect('/login');
        }

    }

}

response\set_body(status: 'failure', message: 'Please fill out the form correctly', values: $fields, errors: $errors);
response\redirect('/signup');
