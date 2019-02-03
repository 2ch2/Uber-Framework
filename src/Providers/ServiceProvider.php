<?php

namespace uber\Providers;

/**
 * Main class of service providers.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
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