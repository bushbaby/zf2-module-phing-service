<?php

namespace BsbPhingServiceTest\Options\Factory;

use BsbPhingService\Options\Factory\PhingOptionsFactory;

class PhingOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateService()
    {
        $smMock  = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $factory = new PhingOptionsFactory();
        $service = $factory->createService($smMock);

        $this->assertInstanceOf('BsbPhingService\Options\PhingOptions', $service);
    }

    public function testMissingOptionsWonResultInWarning()
    {
        $smMock  = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $smMock->expects($this->once())->method('get')->with('config')->willReturn(array());
        $factory = new PhingOptionsFactory();
        $service = $factory->createService($smMock);

        $this->assertInstanceOf('BsbPhingService\Options\PhingOptions', $service);
    }
}
