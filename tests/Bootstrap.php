<?php

use Zend\Loader\AutoloaderFactory;

chdir(__DIR__);
$previousDir = '.';
while (!is_dir($previousDir . DIRECTORY_SEPARATOR . 'vendor')) {
    $appRoot = dirname(getcwd());

    if ($previousDir === $appRoot) {
        throw new RuntimeException('Unable to locate application root');
    }

    $previousDir = $appRoot;
    chdir($appRoot);
}

require_once (getenv('ZF2_PATH') ? : 'vendor/zendframework/zendframework/library') . '/Zend/Loader/AutoloaderFactory.php';

// setup autoloader
AutoloaderFactory::factory();

$rootPath  = realpath(dirname(__DIR__));
$testsPath = "$rootPath/tests";

if (is_readable($testsPath . '/TestConfiguration.php')) {
    require_once $testsPath . '/TestConfiguration.php';
} else {
    require_once $testsPath . '/TestConfiguration.php.dist';
}

\Zend\Loader\AutoloaderFactory::factory(
        array('Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../autoload_classmap.php',
            ),
));
