<?php

namespace PhingService;

use Zend\Module\Consumer\AutoloaderProvider,
    Zend\Module\Listener\ModuleResolverListener;

class Module
{

    public function getConfig($env = null)
    {
        return include __DIR__ . '/configs/module.config.php';
    }

}