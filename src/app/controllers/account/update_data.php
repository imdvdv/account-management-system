<?php

use core\controller;
use core\helpers;
use core\session;
use core\response;
use app\models\user;

$user_id = session\get_user('id');
$fields = controller\prepare_fields_data(user\LABELS['form_profile']);
$errors = user\validate($fields);

if (is_array($fields) && helpers\has_array_keys($fields, ['name', 'email']) && empty($errors)) {

    if ($fields['name'] !== session\get_user('name')) {
        $db_params['name'] = $fields['name'];
    }

    if ($fields['email'] !== session\get_user('email')) {
        $db_params['email'] = $fields['email'];
    }

    if (!empty($db_params)) {
        $db_params['id'] = $user_id;

        if (user\update_by_id($db_params)) {
            session\update_user_data(['name' => $fields['name'], 'email' => $fields['email']]);
            response\set_body(status: 'success', message: 'Your profile data has been updated');
        } else {
            helpers\write_to_log("Failed to update user data by id: {$user_id}", __FILE__);
            response\set_body(status: 'failure', message: 'Failed to edit your profile data. Try again later.');
        }
    }
    
} else {
    response\set_body(status: 'failure', message: 'Please fill out the form correctly', values: $fields, errors: $errors);
}

response\redirect('/');

