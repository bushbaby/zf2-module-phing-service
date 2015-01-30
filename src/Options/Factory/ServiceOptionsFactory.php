<?php

namespace BsbPhingService\Options\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BsbPhingService\Options\Service as ServiceOptions;

class ServiceOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ServiceOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $config = $serviceLocator->get('config');

        $service = new ServiceOptions($config['bsbphingservice']['service']);

        return $service;
    }
}
