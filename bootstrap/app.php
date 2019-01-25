<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/routes.php';

$framework = new \uber\Core\Framework();
$framework->handle();