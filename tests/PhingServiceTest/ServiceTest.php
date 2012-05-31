<?php

namespace PhingServiceTest;

use PhingService\Service,
    PhingService\ServiceOptions,
    PhingService\PhingOptions;

class ServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var PhingService\Service
     */
    protected $service;

    public function setUp()
    {
        $so = new ServiceOptions();
        $po = new PhingOptions();
        $this->service = new Service($so, $po);
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
        $service = new Service($so, $po);
        $result = $service->build();
        $this->assertTrue($result['returnStatus'] == 255); // Buildfile: build.xml does not exist!
    }

}
