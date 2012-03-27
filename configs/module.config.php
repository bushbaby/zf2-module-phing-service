<?php

return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'phing-service'         => 'PhingService\Service',
                'service-configuration' => 'PhingService\ServiceOptions',
                'phing-configuration'   => 'PhingService\PhingOptions'
            ),
            'phing-service'             => array(
                'parameters' => array(
                    'options'               => 'service-configuration',
                    'phingOptions'          => 'phing-configuration'
                ),
            ),
            'service-configuration' => array(
                'parameters' => array(
                    'options' => array(
                        'phpBin'              => null, /* will attempt auto-detection via exec 'which php' */
                        'phingPath'           => 'vendor/phing',
                    ),
                ),
            ),
            'phing-configuration' => array(
                'parameters' => array(
                    'options' => array(
                    ),
                ),
            ),
            // Defining where the layout/layout view should be located
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map' => array(
                        'phingservice/index'          => __DIR__ . '/../view/phingservice/index.phtml',
                    ),
                ),
            ),
            /* Enable this route to get instant gratification at http://localhost/phingservice
             *
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        'phingservice-index' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/phingservice',
                                'defaults' => array(
                                    'controller' => 'PhingService\Controller\PhingServiceController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            /**/
        ),
    ),
);
