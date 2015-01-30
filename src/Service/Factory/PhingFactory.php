<?php

namespace BsbPhingService\Service\Factory;

use BsbPhingService\Service\Phing;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhingFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Phing
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new Phing();

        $service->setOptions($serviceLocator->get('BsbPhingService.serviceOptions'));
        $service->setPhingOptions($serviceLocator->get('BsbPhingService.phingOptions'));

        return $service;
    }
}
