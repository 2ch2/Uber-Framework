<?php

namespace uber\Providers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

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
 * @link https://github.com/Ubermade/mvc-engine
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
        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>
            File: ' . $e->getFile() . '<br>
            Line: ' . $e->getLine() . '<br>
            Trace: ' . $e->getTraceAsString();
            exit;
        }
    }
}