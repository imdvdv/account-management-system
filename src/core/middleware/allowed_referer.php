<?php

namespace core\middleware\allowed_referer;

use core\helpers;
use core\response;
use core\request;

function handle(): void
{
    $path = request\get_path();
    $is_allowed = false;

    foreach (ALLOWED_REFERERS as $key => $value) {

        if ($path == $key || str_starts_with($path, $key)) {
            $is_allowed = helpers\check_referer($value);
            break;
        }

    }

    if (!$is_allowed) {
        response\redirect('/403');
    }

}