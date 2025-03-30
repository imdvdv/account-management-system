<?php

use core\request;
use core\view;
use core\helpers;
use core\session;
use app\models\reset_code;

$get_params = request\get_data();

if (isset($get_params['code']) && helpers\is_code($get_params['code'])) { 
    $code_hash = hash('sha256', $get_params['code']);
    $code_db = reset_code\get_by_hash($code_hash);

    if (isset($code_db['id'], $code_db['dt_exp']) && helpers\is_id($code_db['id']) && helpers\check_expiration_date($code_db['dt_exp'])) {
        session\set_reset($code_db['id'], $get_params['code']);
        view\render_page('recovery');
        exit(); 
    } 

}

session\remove('reset');
view\render_error_page(404, 'Link is incorrect or expire');
