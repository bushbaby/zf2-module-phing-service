<?php

namespace BsbPhingService;

use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

use BsbPhingService\Options\Service as ServiceOptions;
use BsbPhingService\Options\Phing as PhingOptions;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ServiceProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig($env = null)
    {
        return include __DIR__ . '/../../configs/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return array(
            'aliases' => array(

            ),
            'factories' => array(
                'BsbPhingService' => function ($sm) {
                    $service = new Service\Phing();

                    $service->setOptions($sm->get('BsbPhingService.serviceOptions'));
                    $service->setPhingOptions($sm->get('BsbPhingService.phingOptions'));

                    return $service;
                },
                'BsbPhingService.serviceOptions' => function ($sm) {
                    $config = $sm->get('config');

                    return new ServiceOptions($config['bsbphingservice']['service']);
                },
                'BsbPhingService.phingOptions' => function ($sm) {
                    $config = $sm->get('config');

                    return new PhingOptions($config['bsbphingservice']['phing']);
                },
            ),
        );
    }
}