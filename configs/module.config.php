<?php

return array(
    'bsbphingservice' => array(
        'service' => array(
            'phpBin'    => null, /* will attempt auto-detection via exec 'which php' */
            'phingPath' => null, /* will assume composer installation and attempt auto detect */
        ),
        'phing' => array(

        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'BsbPhingService\Controller\Index' => 'BsbPhingService\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'bsb-phing-service/index/index'           => __DIR__ . '/../view/index/index.phtml',
        ),
    )
 );
