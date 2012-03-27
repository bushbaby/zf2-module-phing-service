<?php

namespace PhingService;

use Zend\Module\Consumer\AutoloaderProvider,
    Zend\Module\Listener\ModuleResolverListener;

class Module implements AutoloaderProvider
{

    public function getConfig($env = null)
    {
        return include __DIR__ . '/configs/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(__DIR__ . '/autoload_classmap.php'),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}