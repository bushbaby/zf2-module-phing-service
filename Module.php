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
                    return new \PhingService\ServiceOptions($sm->get('config')->get('PhingService.serviceOptions')->toArray());
                },
                'PhingService.phingOptions' => function ($sm) {
                    return new \PhingService\PhingOptions($sm->get('config')->get('PhingService.phingOptions')->toArray());
                },
            ),
        );
    }
}