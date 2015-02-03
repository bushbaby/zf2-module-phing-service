<?php

namespace BsbPhingServiceTest\Options;

use BsbPhingService\Options\ServiceOptions;

class ServiceOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testSetPhpBinViaConstructor()
    {
        $options = new ServiceOptions(array('phpBin' => 'foo'));
        $this->assertEquals('foo', $options->getPhpBin());
    }

    public function testSetPhpBin()
    {
        $options = new ServiceOptions();
        $options->setPhpBin('foo');
        $this->assertEquals('foo', $options->getPhpBin());
    }

    public function testGetPhpBinAutoDiscoversPhpCommand()
    {
        $php     = exec('which php');
        $options = new ServiceOptions();
        $this->assertEquals($php, $options->getPhpBin());
    }

    public function testSetPhingBinViaConstructor()
    {
        $options = new ServiceOptions(array('phingBin' => 'foo'));
        $this->assertEquals('foo', $options->getPhingBin());
    }

    public function testSetPhpBinToNull()
    {
        $reflectionClass    = new \ReflectionClass('BsbPhingService\Options\ServiceOptions');
        $options            = new ServiceOptions();
        $reflectionProperty = $reflectionClass->getProperty('phpBin');
        $reflectionProperty->setAccessible(true);

        $options->setPhpBin();
        $this->assertNull($reflectionProperty->getValue($options));

        $options->setPhpBin(null);
        $this->assertNull($reflectionProperty->getValue($options));
    }

    public function testSetPhingBin()
    {
        $options = new ServiceOptions();
        $options->setPhingBin('foo');
        $this->assertEquals('foo', $options->getPhingBin());
    }

    public function testSetPhingBinToNull()
    {
        $reflectionClass    = new \ReflectionClass('BsbPhingService\Options\ServiceOptions');
        $options            = new ServiceOptions();
        $reflectionProperty = $reflectionClass->getProperty('phingBin');
        $reflectionProperty->setAccessible(true);

        $options->setPhingBin();
        $this->assertNull($reflectionProperty->getValue($options));

        $options->setPhingBin(null);
        $this->assertNull($reflectionProperty->getValue($options));
    }

    public function testGetPhingBinAutoDiscoversFromComposerJson()
    {
        $cwd     = getcwd();
        $options = new ServiceOptions();
        chdir('./test/BsbPhingServiceTest/_assets');
        $this->assertEquals('./foo/bar/phing', $options->getPhingBin());
        chdir($cwd);
    }

    public function testGetPhingBinAutoDiscoversFromEnvVariable()
    {
        putenv('COMPOSER_BIN_DIR=./foo/bar');
        $options = new ServiceOptions();
        $this->assertEquals('./foo/bar/phing', $options->getPhingBin());
        putenv('COMPOSER_BIN_DIR');
    }

    public function testGetPhingBinDefault()
    {
        $options = new ServiceOptions();
        $this->assertEquals('./vendor/bin/phing', $options->getPhingBin());
    }
}
