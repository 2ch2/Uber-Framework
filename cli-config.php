<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$smModuleArg = false;

foreach ($_SERVER['argv'] as $key => $val) {
    if (preg_match('/--sm-module/', $val)) {
        $smModuleArg = $val;
        unset($_SERVER['argv'][$key]);
        $_SERVER['argc'] = $_SERVER['argc'] - 1;
    }
}

$paths = array(__DIR__ . '/app/Model/');

$config = Setup::createAnnotationMetadataConfiguration($paths, DEBUG_MODE);

try {
    $entityManager = EntityManager::create(DATABASE, $config);
    return ConsoleRunner::createHelperSet($entityManager);
} catch (\Exception $exception) {
    \uber\Utils\ExceptionUtils::displayFullExceptionDetails($exception);
    exit;
}

//Run schema tool update
//For Windows: php vendor/doctrine/orm/bin/doctrine orm:schema-tool:update --force --dump-sql
//For Linux: php vendor/bin/doctrine orm:schema-tool:update --force --dump-sql