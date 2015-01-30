<?php

namespace BsbPhingServiceTest;


use BsbPhingService\Module;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testModuleGetConfig()
    {
        $module = new Module();

        $this->assertNotEmpty($module->getConfig());
    }
}
