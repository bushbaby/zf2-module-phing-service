# BsbPhingService

## Introduction

BsbPhingService is module for Zend Framework 2 that will enable you to execute
[phing](http://www.phing.info/ "Phing") build files from within ZF2 projects.

## Requirements

  * [Zend Framework 2](http://framework.zend.com) >=2.0
  * [Phing](http://www.phing.info) >=2.4.13
  * The ability to execute commandline programs from PHP via [proc_open](http://php.net/manual/en/function.proc-open.php).

[changelog](CHANGELOG.md)
  
[![Latest Stable Version](https://poser.pugx.org/bushbaby/zf2-module-phing-service/v/stable.svg)](https://packagist.org/packages/bushbaby/zf2-module-phing-service)
[![Total Downloads](https://poser.pugx.org/bushbaby/zf2-module-phing-service/downloads.svg)](https://packagist.org/packages/bushbaby/zf2-module-phing-service)
[![Latest Unstable Version](https://poser.pugx.org/bushbaby/zf2-module-phing-service/v/unstable.svg)](https://packagist.org/packages/bushbaby/zf2-module-phing-service)
[![License](https://poser.pugx.org/bushbaby/zf2-module-phing-service/license.svg)](https://packagist.org/packages/bushbaby/zf2-module-phing-service)

[![Build Status](https://scrutinizer-ci.com/g/basz/zf2-module-phing-service/badges/build.png?b=master)]([![Build Status](https://travis-ci.org/basz/zf2-module-phing-service.svg?branch=master)](https://travis-ci.org/basz/zf2-module-phing-service))
[![Code Coverage](https://scrutinizer-ci.com/g/basz/zf2-module-phing-service/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/basz/zf2-module-phing-service/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/basz/zf2-module-phing-service/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/basz/zf2-module-phing-service/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/54cb8adade7924d4b00002ab/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54cb8adade7924d4b00002ab)

---

## Installation

### Using Composer

The recommended way to get a working copy of this project is to modify your composer.json
in your project root. This will take care of dependencies.

    "require":{
        "bushbaby/zf2-module-phing-service":"~2.0",
     },

and then update

	cd /to/your/project/directory
    ./composer.phar update -v
    
## Configuration

  * Open `./configs/application.config.php` and add 'BsbPhingService'
    to the 'modules' parameter to register the module within your application.
  * Optionally copy `./vendor/bushbaby/zf2-module-phing-service/config/bsbphingservice.global.php.dist` to
     `./config/autoload/bsbphingservice.global.php` to override some defaults.

## How to use BsbPhingService

There is only one command to use which is `$service->build($target, $phingOptions);`.

As of version 2.0.0 an instance of the [Symfony Process component](http://symfony.com/doc/current/components/process.html)
is returned when you call 'build'.

```
$process = $phingService->build('target', array('buildFile' => 'build.xml'));
$process->getOutput();
```

A third argument 'immediate' has been added to build which allows you retrieve a configured but unexecuted Process 
instance for whenever you need to do more advanced process management. Such as getting realtime feedback or 
asynchronously running the build.

```
$process = $phingService->build('target', array('buildFile' => 'build.xml'), false);
$process->run(function ($type, $buffer) {
    if (Process::ERR === $type) {
        echo 'ERR > '.$buffer;
    } else {
        echo 'OUT > '.$buffer;
    }
});
```

See the official documentation of [Symfony Process component](http://symfony.com/doc/current/components/process.html).


### Controller example

You can create an instance of the Service manually, however it is recommended to retrieve an
configured instance from the ServiceLocator. The ServiceLocator is available in
every controller so retrieval is trivial.

    public function indexAction() {
        $options = array('buildFile' => __DIR__ . '/../../../data/build-example.xml');

        $buildResult = $this->getServiceLocator()->get('BsbPhingService')->build('show-defaults dist', $options);

        if ($buildResult['returnStatus'] > 0) {
      	    // problem
            echo $buildResult['command'];
            echo $buildResult['output'];
        } else {
            // yeah
            echo $buildResult['output'];
        }

        $view = new ViewModel($buildResult);

        return $view;
    }

To get a quick taste you can enable the defined route in module.conf.php and point your 
browser at `http://yourhost/phingservice` to get an working example.