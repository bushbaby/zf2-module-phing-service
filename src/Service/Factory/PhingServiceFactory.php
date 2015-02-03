<?php

namespace BsbPhingService\Service\Factory;

use BsbPhingService\Service\PhingService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhingServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return PhingService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options      = $serviceLocator->get('BsbPhingService.serviceOptions');
        $phingOptions = $serviceLocator->get('BsbPhingService.phingOptions');

        return new PhingService($options, $phingOptions);
    }
}
