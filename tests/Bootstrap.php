<?php

// Set error reporting pretty high
error_reporting(E_ALL | E_STRICT);

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

// Load composer autoloader
require_once $appRoot . '/vendor/autoload.php';

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

// load autoload of zf2 module if available

if (file_exists(__DIR__ . '/../autoload_classmap.php')) {
\Zend\Loader\AutoloaderFactory::factory(
        array('Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../autoload_classmap.php',
            ),
));
}
