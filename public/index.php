<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/settings.php';
require_once CONFIG . '/init.php';
require_once ROOT . '/vendor/autoload.php';

use core\router;

router\routing();