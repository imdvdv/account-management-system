<?php

namespace core\middleware\guest;

use core\helpers;
use core\response;

function handle(): void
{
    if (helpers\is_authorized()) {
        response\redirect('/');
    } elseif (helpers\is_remembered()) {
        response\redirect('/auth/token');
    }
}