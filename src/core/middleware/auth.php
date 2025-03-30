<?php

namespace core\middleware\auth;

use core\helpers;
use core\response;

function handle(): void
{
    if (helpers\is_authorized()) {
        helpers\extend_token_expiration_date();
    } elseif (helpers\is_remembered()) {
        response\redirect('/auth/token');
    } else {
        response\redirect('/login');
    }
}