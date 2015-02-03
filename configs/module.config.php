<?php

return array(
    'bsbphingservice' => array(
        'service' => array(
            'phpBin'    => null, /* will attempt auto-detection */
            'phingBin'  => null, /* will attempt auto-detection, defaults to ./vendor/bin/phing */
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
            'BsbPhingService'                => 'BsbPhingService\Service\Factory\PhingServiceFactory',
            'BsbPhingService.serviceOptions' => 'BsbPhingService\Options\Factory\ServiceOptionsFactory',
            'BsbPhingService.phingOptions'   => 'BsbPhingService\Options\Factory\PhingOptionsFactory',
        ),
    ),
);
