<?php

namespace BsbPhingServiceTest;

use BsbPhingService\Controller\IndexController;
use BsbPhingService\Options\PhingOptions;
use BsbPhingService\Options\ServiceOptions;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexAction()
    {
        $processMock = $this->getMockBuilder('Symfony\Component\Process\Process')->disableOriginalConstructor()
            ->getMock();
        $phingMock   = $this->getMockBuilder('BsbPhingService\Service\PhingService')->setConstructorArgs(array(
            new ServiceOptions(),
            new PhingOptions()
        ))->getMock();
        $phingMock->expects($this->once())->method('build')->withAnyParameters()->willReturn($processMock);

        $smMock = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $smMock->expects($this->once())->method('get')->with('BsbPhingService')->willReturn($phingMock);
        $controller = new IndexController();
        $controller->setServiceLocator($smMock);

        $viewModel = $controller->indexAction();
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $viewModel);
        $this->assertInstanceOf('Symfony\Component\Process\Process', $viewModel->getVariable('process'));
        $this->assertEquals($processMock, $viewModel->getVariable('process'));
    }
}
