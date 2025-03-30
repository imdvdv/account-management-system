<?php

use core\controller;
use core\response;
use core\helpers;
use app\models\user;
use app\models\reset_code;

$fields = controller\prepare_fields_data(user\LABELS['form_email']);
$errors = user\validate($fields);

if (isset($fields['email']) && empty($errors)) {
    $user_db = user\get_by_email($fields['email']);

    if (isset($user_db['id']) && helpers\is_id($user_db['id'])) {
        $user_id = (int)$user_db['id'];
        $code = helpers\generate_code();
        $db_params = controller\prepare_code_params($user_id, $code, time() + ONE_HOUR);
        reset_code\refresh_by_user_id($db_params);
        
        // Generate and send an email with a link to the password change page
        $subject = 'Password recovery';
        $message = 'To reset a password and create new - <a href="'. BASE_URL . '/recovery?code=' . $code . '">click here</a>. </br>Reset your password in a hour.';

        if (!helpers\send_mail($fields['email'], $subject, $message)) {
            response\set_body(message: 'The email couldn`t be sent due to technical reasons. Please try again later.');
            helpers\write_to_log("Failed to send message to {$fields['email']}. User id: {$user_id}", __FILE__);
        } else {
            response\set_body(status: 'success', message: 'Instructions has been sent to the specified email address');
            response\redirect('/');
        }

    } else {
        response\set_body(message: 'There are no registered users with the specified address');
    }

} else {
    response\set_body(message: 'Please fill out the form correctly');
}

response\set_body(status: 'failure', values: $fields, errors: $errors);
response\redirect(); 


