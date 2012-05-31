<?php

return array(
    'PhingService.serviceOptions' => array(
        'phpBin'                    => null, /* will attempt auto-detection via exec 'which php' */
        'phingPath'                 => null, /* will assume composer installation and attempt auto detect */
    ),
    'PhingService.phingOptions' => array(
    ),
    'controller' => array(
        // Map of controller "name" to class
        // This should be used if you do not need to inject any dependencies
        // in your controller
        'classes' => array(
            'phingservice.index' => 'PhingService\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'PhingService' => __DIR__ . '/../view',
        ),
    ),
);
