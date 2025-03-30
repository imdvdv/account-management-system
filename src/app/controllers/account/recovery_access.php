<?php

use core\controller;
use core\session;
use core\response;
use core\helpers;
use core\db;
use app\models\user;
use app\models\auth_token;
use app\models\reset_code;

if (session\has_reset()) {
    $code_id = session\get_reset('code_id');
    $code_db = reset_code\get_by_id($code_id);

    if (isset($code_db['user_id'], $code_db['code_hash'], $code_db['dt_exp']) && helpers\check_expiration_date($code_db['dt_exp'])) {
        $user_id = (int)$code_db['user_id'];

        if (hash_equals($code_db['code_hash'], hash('sha256', session\get_reset('code')))) {
            $fields = controller\prepare_fields_data(user\LABELS['form_recovery']);
            $errors = user\validate($fields);

            if (empty($errors) && isset($fields['password'], $fields['confirm_password'])) {

                if ($fields['password'] === $fields['confirm_password']) {
                    $db_params = [
                        'hash' => password_hash($fields['password'], PASSWORD_DEFAULT),
                        'id' => $user_id
                    ];
                    db\begin_transaction();
                    user\update_by_id($db_params);
                    auth_token\remove_by_user_id($user_id); // remove all active sessions for this user
                    reset_code\remove_by_id($code_id); // remove current reset code
                    
                    if (db\commit()) {
                        session\remove('recovery');
                        response\set_body(status: 'success', message: 'Your password has been successfully changed!'); 
                    } else {
                        db\roll_back();
                        response\set_body(status: 'failure', message: 'Failed to change password. Try again later'); 
                        helpers\write_to_log("Failed to update password by user id: {$user_id}", __FILE__);
                    }

                    response\redirect('/');                        
                } else {
                    $errors['confirm_password'] = 'passwords must match';
                }  
                
            }

            response\set_body(status: 'failure', message: 'Please fill out the form correctly', values: $fields, errors: $errors);
        }

    }

}

response\redirect();



