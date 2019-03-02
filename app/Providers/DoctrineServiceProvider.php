<?php

namespace app\Providers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use uber\Utils\ExceptionUtils;

/**
 * Provider for orm doctrine.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 */
class DoctrineServiceProvider extends ServiceProvider
{
    /**
     * @param array $options
     * @return EntityManager
     */
    public function provide(array $options = [])
    {
        $config = Setup::createAnnotationMetadataConfiguration([], DEBUG_MODE);

        try {
            return EntityManager::create($this->config, $config);
        } catch (\Exception $exception) {
            ExceptionUtils::displayFullExceptionDetails($exception);
            exit;
        }
    }
}