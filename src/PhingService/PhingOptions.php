<?php

namespace PhingService;

use Zend\Stdlib\AbstractOptions;
use Zend\Stdlib\Parameters;

class PhingOptions extends AbstractOptions
{

    protected $buildFile    = null;
    protected $logger       = null;
    protected $logFile      = null;
    protected $propertyFile = null;

    /**
     *
     * @var Parameters
     */
    protected $properties   = null;
    protected $inputHandler = null;
    protected $longTargets  = null;
    protected $list         = null;
    protected $find         = null;

    public function __construct(array $options = null)
    {
        $this->properties = new Parameters(array());

        parent::__construct($options);
    }

    public function setBuildFile($path)
    {
        if (!is_file($path)) {
            throw new \RuntimeException(sprintf("Path '%s' does not exists '%s'", 'buildFile', $path));
        }

        if (pathinfo($path, PATHINFO_EXTENSION) != 'xml') {
            throw new \InvalidArgumentException(sprintf("File '%s' is not an xml file '%s'", 'buildFile', $path));
        }

        $this->buildFile = (string) realpath($path);
    }

    public function getBuildFile()
    {
        return $this->buildFile;
    }

    public function setLogger($logger)
    {
        $this->logger = (string) $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogFile($logFile)
    {
        $this->logFile = (string) $logFile;
    }

    public function getLogFile()
    {
        return $this->logFile;
    }

    public function setPropertyFile($file)
    {
        $this->propertyFile = (string) $file;
    }

    public function getPropertyFile()
    {
        return $this->propertyFile;
    }

    public function setInputHandler($className)
    {
        $this->inputHandler = (string) $className;
    }

    public function getInputHandler()
    {
        return $this->inputHandler;
    }

    public function setProperties(array $properties)
    {
        $this->properties->fromArray($properties);
    }

    public function getProperties()
    {
        return $this->properties->toArray();
    }

    public function setLongTargets($targets)
    {
        $this->longTargets = filter_var($targets, FILTER_VALIDATE_BOOLEAN);
    }

    public function getLongTargets()
    {
        return (bool) $this->longTargets;
    }

    public function setList($value)
    {
        $this->list = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function getList()
    {
        return (bool) $this->list;
    }

    public function setFind($value)
    {
        $this->find = $value;
    }

    public function getFind()
    {
        return $this->find;
    }
}
