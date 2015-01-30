<?php

return array(
    'bsbphingservice' => array(
        'service' => array(
            'phpBin'    => null, /* will attempt auto-detection via exec 'which php' */
            'phingPath' => null, /* will assume composer installation and attempt auto detect */
        ),
        'phing'   => array(),
    ),
    'controllers'     => array(
        'invokables' => array(
            'BsbPhingService\Controller\Index' => 'BsbPhingService\Controller\IndexController',
        ),
    ),
    'view_manager'    => array(
        'template_map' => array(
            'bsb-phing-service/index/index' => __DIR__ . '/../view/index/index.phtml',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'BsbPhingService'                => 'BsbPhingService\Service\Factory\PhingFactory',
            'BsbPhingService.serviceOptions' => 'BsbPhingService\Options\Factory\PhingServiceFactory',
            'BsbPhingService.phingOptions'   => 'BsbPhingService\Options\Factory\PhingOptionsFactory',
        ),
    ),
);
