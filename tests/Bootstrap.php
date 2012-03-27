<?php

require_once __DIR__ . '/../autoload_register.php';

$rootPath  = realpath(dirname(__DIR__));
$testsPath = "$rootPath/tests";

if (is_readable($testsPath . '/TestConfiguration.php')) {
    require_once $testsPath . '/TestConfiguration.php';
} else {
    require_once $testsPath . '/TestConfiguration.php.dist';
}

$path = array(
    $testsPath,
    ZEND_FRAMEWORK_PATH,
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $path));

require_once 'Zend/Loader/AutoloaderFactory.php';
\Zend\Loader\AutoloaderFactory::factory(
        array('Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
        )));

//
//$listenerOptions = new Zend\Module\Listener\ListenerOptions(array('module_paths' => array(__DIR__ . '/..')));
//$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);
//$defaultListeners->getConfigListener()->addConfigGlobPath("config/autoload/{module.*,global,$env,local}.config.php");
//
//$moduleManager = new Zend\Module\Manager(array('PhingService'));
//$moduleManager->events()->attachAggregate($defaultListeners);
//$moduleManager->loadModules();
//





//$config 	 = $defaultListeners->getConfigListener()->getMergedConfig();

//$di = new \Zend\Di\Di;
//$di->instanceManager()->addTypePreference('Zend\Di\Locator', $di);

//$config = new \Zend\Di\Configuration($config['di']);
//$config->configure($di);

//require_once __DIR__ . '/PhingServiceTest/TestCase.php';
//\PhingServiceTest\TestCase::$locator = $di;