<?php

namespace BsbPhingServiceTest\Service\Factory;

use BsbPhingService\Options\PhingOptions;
use BsbPhingService\Options\ServiceOptions;
use BsbPhingService\Service\Factory\PhingServiceFactory;

class PhingServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateService()
    {
        $smMock = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $smMock->expects($this->at(0))->method('get')->with('BsbPhingService.serviceOptions')
            ->willReturn(new ServiceOptions());
        $smMock->expects($this->at(1))->method('get')->with('BsbPhingService.phingOptions')
            ->willReturn(new PhingOptions());
        $factory = new PhingServiceFactory();
        $service = $factory->createService($smMock);

        $this->assertInstanceOf('BsbPhingService\Service\PhingService', $service);
    }
}
