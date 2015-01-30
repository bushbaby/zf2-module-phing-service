<?php

namespace BsbPhingService\Options\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BsbPhingService\Options\Phing as PhingOptions;

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

        $config = $serviceLocator->get('config');

        $service = new PhingOptions($config['bsbphingservice']['phing']);

        return $service;
    }
}
