<?php

namespace BsbPhingServiceTest;

use BsbPhingService\Service\Phing;
use BsbPhingService\Options\Service as ServiceOptions;
use BsbPhingService\Options\Phing as PhingOptions;

class ServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BsbPhingService\Service\Phing $service
     */
    protected $service;

    public function setUp()
    {
        $so = new ServiceOptions();
        $po = new PhingOptions();
        $this->service = new Phing($so, $po);
    }

    public function testOptionDiscoveryPhpBin()
    {
        $so = new ServiceOptions();
        $this->assertNotNull($so->getPhpBin());
    }

    public function testOptionDiscoveryPhingPath()
    {
        $so = new ServiceOptions();
        $this->assertNotNull($so->getPhingPath());
        $this->assertTrue(is_dir($so->getPhingPath()));
    }

    public function testPhingRuns()
    {
        $so = new ServiceOptions();
        $po = new PhingOptions();
        $service = new Phing($so, $po);
        $result = $service->build();
        $this->assertEquals(255, $result['returnStatus']); // Buildfile: build.xml does not exist!
    }

}
