<?php

namespace BsbPhingService\Options;

use Zend\Stdlib\AbstractOptions;
use Zend\Stdlib\Parameters;

class PhingOptions extends AbstractOptions
{

    /**
     * @var string Path to buildfile
     */
    private $buildFile;

    /**
     * @var string (optional) Class which is to perform logging
     */
    private $logger;

    /**
     * @var string (optional) Path to file for logging
     */
    private $logFile;

    /**
     * @var string (optional) Path to file containing all properties
     */
    private $propertyFile;

    /**
     * @var Parameters Container of key/values send as properties to phing
     */
    private $properties;

    /**
     * @var string (optional) class to use to handle user input
     */
    private $inputHandler;

    /**
     * @var boolean Show target descriptions during build
     */
    private $longTargets = false;

    /**
     * @var boolean Lists available targets in this project
     */
    private $list = false;

    /**
     * @var string (optional) Search for a file towards the root of the filesystem and use it as buildfile
     */
    private $find;

    /**
     * @var bool Be extra quiet
     */
    private $quiet = false;

    /**
     * @var bool Print debugging information
     */
    private $debug = false;

    /**
     * @var bool Be extra verbose
     */
    private $verbose = false;

    /**
     * @param array $options
     */
    public function __construct(array $options = null)
    {
        $this->properties = new Parameters();

        parent::__construct($options);
    }

    /**
     * @return string
     */
    public function getBuildFile()
    {
        return $this->buildFile;
    }

    /**
     * @param string $buildFile
     */
    public function setBuildFile($buildFile)
    {
        $this->buildFile = $buildFile;
    }

    /**
     * @return string
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param string $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return string
     */
    public function getLogFile()
    {
        return $this->logFile;
    }

    /**
     * @param string $logFile
     */
    public function setLogFile($logFile)
    {
        $this->logFile = $logFile;
    }

    /**
     * @return string
     */
    public function getPropertyFile()
    {
        return $this->propertyFile;
    }

    /**
     * @param string $propertyFile
     */
    public function setPropertyFile($propertyFile)
    {
        $this->propertyFile = $propertyFile;
    }

    /**
     * @return string
     */
    public function getInputHandler()
    {
        return $this->inputHandler;
    }

    /**
     * @param string $inputHandler
     */
    public function setInputHandler($inputHandler)
    {
        $this->inputHandler = $inputHandler;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties->toArray();
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties->fromArray($properties);
        ;
    }

    /**
     * @return boolean
     */
    public function isList()
    {
        return $this->list;
    }

    /**
     * @param boolean $list
     */
    public function setList($list)
    {
        $this->list = filter_var($list, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return boolean
     */
    public function isLongTargets()
    {
        return $this->longTargets;
    }

    /**
     * @param boolean $longTargets
     */
    public function setLongTargets($longTargets)
    {
        $this->longTargets = filter_var($longTargets, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return string
     */
    public function getFind()
    {
        return $this->find;
    }

    /**
     * @param string $find
     */
    public function setFind($find)
    {
        $this->find = $find;
    }

    /**
     * @return boolean
     */
    public function isQuiet()
    {
        return $this->quiet;
    }

    /**
     * @param boolean $quiet
     */
    public function setQuiet($quiet)
    {
        $this->quiet = filter_var($quiet, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return boolean
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * @param boolean $debug
     */
    public function setDebug($debug)
    {
        $this->debug = filter_var($debug, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return boolean
     */
    public function isVerbose()
    {
        return $this->verbose;
    }

    /**
     * @param boolean $verbose
     */
    public function setVerbose($verbose)
    {
        $this->verbose = filter_var($verbose, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Construct an array with arguments to configure the phing executable
     *
     * @return array
     */
    public function toArgumentsArray()
    {
        $arguments = array();

        if ($this->getBuildFile()) {
            $arguments[] = "-buildfile";
            $arguments[] = $this->getBuildFile();
        }

        if ($this->getLogger()) {
            $arguments[] = "-logger";
            $arguments[] = $this->getLogger();
        }

        if ($this->getLogFile()) {
            $arguments[] = "-logfile";
            $arguments[] = $this->getLogFile();
        }

        if ($this->getPropertyFile()) {
            $arguments[] = "-propertyfile";
            $arguments[] = $this->getPropertyFile();
        }

        if ($this->getInputHandler()) {
            $arguments[] = "-inputhandler";
            $arguments[] = $this->getInputHandler();
        }

        if ($this->getFind()) {
            $arguments[] = "-find";
            $arguments[] = $this->getFind();
        }

        if ($this->isLongTargets()) {
            $arguments[] = "-longtargets";
        }

        if ($this->isList()) {
            $arguments[] = "-list";
        }

        if ($this->isVerbose()) {
            $arguments[] = "-verbose";
        }

        if ($this->isDebug()) {
            $arguments[] = "-debug";
        }

        if ($this->isQuiet()) {
            $arguments[] = "-quiet";
        }

        foreach ($this->getProperties() as $key => $value) {
            $arguments[] = sprintf("-D%s=%s", (string) $key, (string) $value);
        }

        return $arguments;
    }
}
