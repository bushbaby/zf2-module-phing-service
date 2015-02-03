<?php

namespace BsbPhingServiceTest;

use BsbPhingService\Options\PhingOptions as PhingOptions;
use BsbPhingService\Options\ServiceOptions as ServiceOptions;
use BsbPhingService\Service\PhingService;

class PhingServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testAcceptOptions()
    {
        $serviceOptions = new ServiceOptions();
        $phingOptions   = new PhingOptions();
        $service        = new PhingService($serviceOptions, $phingOptions);

        $this->assertEquals($phingOptions, $service->getPhingOptions());
        $this->assertEquals($serviceOptions, $service->getOptions());
    }

    public function testBuildReturnsCorrectInstanceOf()
    {
        $so      = new ServiceOptions();
        $po      = new PhingOptions();
        $service = new PhingService($so, $po);
        $process = $service->build();

        $this->assertInstanceOf('Symfony\Component\Process\Process', $process);
    }

    public function testBuildWithImmediateFlag()
    {
        $serviceOptions = new ServiceOptions();
        $phingOptions   = new PhingOptions();
        $service        = new PhingService($serviceOptions, $phingOptions);

        $result = $service->build();
        $this->assertEquals('terminated', $result->getStatus());
        $this->assertNotNull($result->getExitCode());

        $result = $service->build(null, null, true);
        $this->assertEquals('terminated', $result->getStatus());
        $this->assertNotNull($result->getExitCode());

        $result = $service->build(null, null, false);
        $this->assertEquals('ready', $result->getStatus());
        $this->assertNull($result->getExitCode());
    }

    public function testBuildWithBuildExample()
    {
        $serviceOptions = new ServiceOptions();
        $phingOptions   = new PhingOptions();
        $service        = new PhingService($serviceOptions, $phingOptions);

        $result = $service->build('show-defaults dist', array(
            'build_file' => './test/BsbPhingServiceTest/_assets/build-example.xml'));

        $this->assertTrue($result->getExitCode() === 0);

        $this->assertContains('PhingService Demo Project > show-defaults', $result->getOutput());
        $this->assertContains('PhingService Demo Project > dist', $result->getOutput());
    }

    public function testBuildOverridingDefaultPhingOtions()
    {
        $serviceOptions = new ServiceOptions();
        $phingOptions   = new PhingOptions();
        $phingOptions->isVerbose(true);
        $service        = new PhingService($serviceOptions, $phingOptions);

        $result = $service->build('show-defaults dist', array(
            'build_file' => './test/PhingServiceTest/_assets/build-example.xml', 'verbose' => false));

        $this->assertNotContains('-verbose', $result->getCommandLine());
    }
}
