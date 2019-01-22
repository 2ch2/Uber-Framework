<?php

namespace uber\Providers;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFunction;

/**
 * Provider for twig.
 *
 * Class TwigServiceProvider
 *
 * @category Provider
 *
 * @package uber\Providers
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/Ubermade/Uber-Framework
 */
class TwigServiceProvider extends ServiceProvider
{
    /**
     * @param array $options
     * @return Twig_Environment
     */
    public function provide(array $options = []): ?Twig_Environment
    {
        $loader = new Twig_Loader_Filesystem($this->config['dir']);
        $twig = new Twig_Environment($loader, array(
            'cache' => $this->config['cache'],
            'auto_reload' => true
        ));

        $functionGenerateUrl = new Twig_SimpleFunction('url', function ($name, $parameters = null) use($options){
            return $options['urlGenerator']->generate($name, $parameters);
        });

        $twig->addFunction($functionGenerateUrl);

        return $twig;
    }
}