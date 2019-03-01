<?php

namespace uber\Providers;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFunction;

/**
 * Provider for twig.
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
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

        //Here create functions for twig.
        $functionGenerateUrl = new Twig_SimpleFunction('url', function ($name, $parameters = null) use($options){
            return $options['urlGenerator']->generate($name, $parameters);
        });

        $functionDisplaySession = new Twig_SimpleFunction('session', function ($name) use($options){
            return $options['session']->get($name);
        });

        $functionSessionExists = new Twig_SimpleFunction('isSession', function ($name) use($options){
            return $options['session']->isSessionExists($name);
        });

        $functionAsset = new Twig_SimpleFunction('asset', function ($path){
            return HTTP_SERVER.'public/'.$path;
        });

        //Here include created functions.
        $twig->addFunction($functionGenerateUrl);
        $twig->addFunction($functionDisplaySession);
        $twig->addFunction($functionSessionExists);
        $twig->addFunction($functionAsset);

        return $twig;
    }

    public function defaultVariables()
    {
        $this->defaultVariables = [

        ];
    }

}