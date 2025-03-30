<?php

use core\controller;
use core\helpers;
use core\session;
use core\response;
use app\models\user;

$user_id = session\get_user('id');
$fields = controller\prepare_fields_data(user\LABELS['form_avatar']);
$errors = user\validate($fields);

if (isset($fields['avatar']) && helpers\is_file($fields['avatar'])) {

    if (empty($errors)) {
        $new_avatar_path = helpers\upload_file($fields['avatar'], 'avatars');

        if (!$new_avatar_path) {
            $errors['avatar'] = 'Failed to upload file. Try again later.';
        }

        $db_params = [
            'avatar' => $new_avatar_path,
            'id' => $user_id
        ];

        if (user\update_by_id($db_params)) {

            if (session\has_user('avatar')) {
                $old_avatar_path = PUBLIC_DIR . '/' . session\get_user('avatar');

                if (!unlink($old_avatar_path)) {
                    helpers\write_to_log("Failed to delete profile avatar {$old_avatar_path} by user ID {$user_id}", __FILE__);
                }

            }

            session\update_user_data(['avatar' => $new_avatar_path]);
            response\redirect('/');
        }

    }

}

response\set_body(errors: $errors);
response\redirect('/popup/upload-avatar');