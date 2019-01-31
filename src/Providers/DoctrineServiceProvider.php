<?php

namespace uber\Providers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use uber\Utils\ExceptionUtils;

/**
 * Provider for orm doctrine.
 *
 * Class DoctrineServiceProvider
 *
 * @category Provider
 *
 * @package uber\Providers
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/kamil-ubermade/Uber-Framework
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