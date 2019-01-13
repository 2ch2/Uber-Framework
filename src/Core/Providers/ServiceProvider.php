<?php

namespace Core\Providers;

/**
 * Main class of service providers.
 *
 * Class ServiceProvider
 *
 * @category Provider
 *
 * @package Core\Providers
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/mvc-engine
 */
abstract class ServiceProvider
{
    /**
     * @var array
     */
    protected $config;

    /**
     * ServiceProvider constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    abstract public function provide(array $options = []);
}