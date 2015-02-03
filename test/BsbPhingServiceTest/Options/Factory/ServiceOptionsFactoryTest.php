<?php

namespace BsbPhingServiceTest\Options\Factory;

use BsbPhingService\Options\Factory\ServiceOptionsFactory;

class ServiceOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateService()
    {
        $smMock  = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $factory = new ServiceOptionsFactory();
        $service = $factory->createService($smMock);

        $this->assertInstanceOf('BsbPhingService\Options\ServiceOptions', $service);
    }

    public function testMissingOptionsWonResultInWarning()
    {
        $smMock  = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $smMock->expects($this->once())->method('get')->with('config')->willReturn(array());
        $factory = new ServiceOptionsFactory();
        $service = $factory->createService($smMock);
        
        $this->assertInstanceOf('BsbPhingService\Options\ServiceOptions', $service);
    }
}
