<?php

namespace BsbPhingServiceTest\Options;

use BsbPhingService\Options\Factory\PhingOptionsFactory;
use BsbPhingService\Options\PhingOptions;

class PhingOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testArgumentsArrayIsEmpty()
    {
        $options = new PhingOptions();
        $this->assertEmpty($options->toArgumentsArray());
    }

    public function testArgumentsArrayBuildFile()
    {
        $options = new PhingOptions();
        $options->setBuildFile('foo.xml');
        $this->assertEquals(array('-buildfile', 'foo.xml'), $options->toArgumentsArray());
    }

    public function testArgumentsArrayLogger()
    {
        $options = new PhingOptions();
        $options->setLogger('foo');
        $this->assertEquals(array('-logger', 'foo'), $options->toArgumentsArray());
    }

    public function testArgumentsArrayLogFile()
    {
        $options = new PhingOptions();
        $options->setLogFile('foo');
        $this->assertEquals(array('-logfile', 'foo'), $options->toArgumentsArray());
    }

    public function testArgumentsArrayPropertyFile()
    {
        $options = new PhingOptions();
        $options->setPropertyFile('foo');
        $this->assertEquals(array('-propertyfile', 'foo'), $options->toArgumentsArray());
    }

    public function testArgumentsArrayInputHandler()
    {
        $options = new PhingOptions();
        $options->setInputHandler('foo');
        $this->assertEquals(array('-inputhandler', 'foo'), $options->toArgumentsArray());
    }

    public function testArgumentsArrayFind()
    {
        $options = new PhingOptions();
        $options->setFind('foo');
        $this->assertEquals(array('-find', 'foo'), $options->toArgumentsArray());
    }

    public function testArgumentsProperties()
    {
        $options = new PhingOptions();
        $options->setProperties(array('foo'=>'bar'));
        $this->assertEquals(array('-Dfoo=bar'), $options->toArgumentsArray());
    }

    public function testArgumentsArrayBooleans()
    {
        $options = new PhingOptions();

        $options->setDebug(true);
        $options->setList(true);
        $options->setLongTargets(true);
        $options->setQuiet(true);
        $options->setVerbose(true);

        $this->assertContains('-debug', $options->toArgumentsArray());
        $this->assertContains('-list', $options->toArgumentsArray());
        $this->assertContains('-longtargets', $options->toArgumentsArray());
        $this->assertContains('-quiet', $options->toArgumentsArray());
        $this->assertContains('-verbose', $options->toArgumentsArray());
    }
}
