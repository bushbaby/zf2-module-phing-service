<?php

namespace BsbPhingService\Options;

use Zend\Stdlib\AbstractOptions;
use BsbPhingService\Service\Phing;

class Service extends AbstractOptions
{

    /**
     * Path to cli php
     *
     * @var string
     */
    protected $phpBin = null;

    /**
     * Path to phing library installation
     *
     * @var type
     */
    protected $phingPath = false;

    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }

    public function setPhpBin($path = null)
    {
        if ($path === null) {
            if (!Phing::hasExec()) {
                throw new \RuntimeException("Not able to use PHP's exec method");
            }

            $res  = exec('which php', $o, $val);
            $path = ($val === 0) ? $res : null;
        }

        if (!is_file($path) || !is_executable($path)) {
            throw new \RuntimeException(sprintf("The provided php binary does not exists or is not executable '%s'", $path));
        }

        $this->phpBin = (string) $path;
    }

    public function getPhpBin()
    {
        if ($this->phpBin == null) {
            // set with null to try to do auto-discover php bin
            $this->setPhpBin();

            // still null? complain!
            if ($this->phpBin == null) {
                throw new \RuntimeException(sprintf("We cannot auto discover the path to your cli php, therefore can't run phing!", $path));
            }
        }

        return $this->phpBin;
    }

    /**
     * Sets the path to the phing library installation
     *
     * @param string $path
     * @throws \RuntimeException When path can't be found
     */
    public function setPhingPath($path)
    {
        if ($path === null) {
            $this->phingPath = null;

            return;
        }

        if (!is_dir(realpath($path))) {
            throw new \RuntimeException(sprintf("Path '%s' does not exists '%s'", 'phingPath', $path));
        }

        $this->phingPath = realpath($path);
    }

    public function getPhingPath()
    {
        if ($this->phingPath == null) {
            // set with null to try to do auto-discover phing lib in vendor
            $this->setPhingPath(realpath('.') . DIRECTORY_SEPARATOR . 'vendor/phing/phing');

            // still null? complain!
            if ($this->phingPath == null) {
                throw new \RuntimeException(sprintf("We cannot auto discover the path to the phing library, therefore can't run phing!", $path));
            }
        }

        return $this->phingPath;
    }

    public function getPhingBin()
    {
        return $this->getPhingPath() . '/bin/phing';
    }

}
