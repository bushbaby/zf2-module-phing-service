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

    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'PhingService' => function ($sm) {
                    $service = new \PhingService\Service();

                    $service->setOptions($sm->get('PhingService.serviceOptions'));
                    $service->setPhingOptions($sm->get('PhingService.phingOptions'));

                    return $service;
                },
                'PhingService.serviceOptions' => function ($sm) {
                    $config = $sm->get('config');
                    return new \PhingService\ServiceOptions($config['PhingService.serviceOptions']);
                },
                'PhingService.phingOptions' => function ($sm) {
                    $config = $sm->get('config');
                    return new \PhingService\PhingOptions($config['PhingService.phingOptions']);
                },
            ),
        );
    }
}