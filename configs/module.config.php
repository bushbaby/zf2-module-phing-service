<?php

return array(
    'PhingService.serviceOptions' => array(
        'phpBin'                    => null, /* will attempt auto-detection via exec 'which php' */
        'phingPath'                 => null, /* will assume composer installation and attempt auto detect */
    ),
    'PhingService.phingOptions' => array(
    ),
    'controllers' => array(
        'invokables' => array(
            'phingservice.index' => 'PhingService\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'PhingService' => __DIR__ . '/../view',
        ),
    ),
);
