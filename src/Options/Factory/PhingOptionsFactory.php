<?php

namespace BsbPhingService\Options\Factory;

use BsbPhingService\Options\PhingOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PhingOptionsFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return PhingOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config  = $serviceLocator->get('config');
        $config  = isset($config['bsbphingservice']['phing']) ? $config['bsbphingservice']['phing'] : array();
        $service = new PhingOptions($config);

        return $service;
    }
}
