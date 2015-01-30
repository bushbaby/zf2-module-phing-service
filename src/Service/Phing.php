<?php

namespace BsbPhingService\Service;

use BsbPhingService\Options\Phing as PhingOptions;
use BsbPhingService\Options\Service as ServiceOptions;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class Phing
{

    /**
     * @var ServiceOptions
     */
    protected $options;

    /**
     * @var PhingOptions
     */
    protected $phingOptions;

    public function __construct(ServiceOptions $options = null, PhingOptions $phingOptions = null)
    {
        $this->options      = $options;
        $this->phingOptions = $phingOptions;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(ServiceOptions $options)
    {
        $this->options = $options;
    }

    public function getPhingOptions()
    {
        return $this->phingOptions;
    }

    public function setPhingOptions(PhingOptions $phingOptions)
    {
        $this->phingOptions = $phingOptions;
    }

    /**
     *
     * @param  string                 $target
     * @param  null|array|Traversable $options
     * @return array
     */
    public function build($target = "", $options = null)
    {
        $phingOptions = clone $this->phingOptions;

        if ($options) {
            if (!is_array($options) && !$options instanceof Traversable) {
                throw new \InvalidArgumentException(sprintf(
                    'Parameter provided to %s must be an array or Traversable',
                    __METHOD__
                ));
            }

            $phingOptions->setFromArray($options);
        }

        return $this->doBuild($target, $phingOptions);
    }

    /**
     * @param string       $targets space separated list of targets
     * @param PhingOptions $options
     * @return array
     */
    protected function doBuild($targets, PhingOptions $options)
    {
        if (!self::hasExec()) {
            throw new \RuntimeException("Not able to use PHP's exec method");
        }

        $builder = new ProcessBuilder();

        $builder->setPrefix($this->options->getPhingBin());
        $builder->setArguments($this->getPhingCommandArgumentsArray($options));

        foreach($this->getEnv() as $key=>$value) {
            $builder->setEnv($key, $value);
        }

        foreach(explode(' ', $targets) as $target) {
            if (strlen(trim($target))) {
                $builder->add(trim($target));
            }
        }

        $process = $builder->getProcess();

        $process->run();

        $result = array(
            'command'      => $process->getCommandLine(),
            'output'       => $process->getOutput(),
            'returnStatus' => $process->getExitCode()
        );

        return $result;
    }

    public static function hasExec()
    {
        static $capable;

        if ($capable === null) {
            $_capable = function_exists('exec');

            foreach (array_map('trim', explode(',', ini_get('disable_functions'))) as $func) {
                if ($func == 'exec') {
                    $_capable = false;
                }
            }

            $capable = $_capable;
        }

        return $capable;
    }

    /**
     * Construct an array with commands to configure the cli environment
     *
     * @return array
     */
    protected function getEnv()
    {
        $env = array();

        $env['PHP_COMMAND']   = $this->options->getPhpBin();
        $env['PHING_HOME']    = $this->options->getPhingPath();
        $env['PHP_CLASSPATH'] = sprintf('%s%sclasses', $this->options->getPhingPath(), DIRECTORY_SEPARATOR);
        $env['PATH']          = sprintf(
            '%s%s%s%sbin',
            $_SERVER['PATH'],
            PATH_SEPARATOR,
            DIRECTORY_SEPARATOR,
            $this->options->getPhingPath()
        );

        return $env;
    }

    /**
     * Construct an array with arguments to configure the phing binary
     *
     * @param  PhingOptions $options
     * @return array
     */
    protected function getPhingCommandArgumentsArray(PhingOptions $options)
    {
        $arguments = array();

        if ($options->getBuildFile()) {
            $arguments[] = "-buildfile";
            $arguments[] = $options->getBuildFile();
        }

        if ($options->getLogger()) {
            $arguments[] = "-logger";
            $arguments[] = $options->getLogger();
        }

        if ($options->getLogFile()) {
            $arguments[] = "-logfile";
            $arguments[] = $options->getLogFile();
        }

        if ($options->getPropertyFile()) {
            $arguments[] = "-propertyfile";
            $arguments[] = $options->getPropertyFile();
        }

        if ($options->getInputHandler()) {
            $arguments[] = "-inputhandler";
            $arguments[] = $options->getInputHandler();
        }

        if ($options->getFind()) {
            $arguments[] = "-find";
            $arguments[] = $options->getFind();
        }

        if ($options->getLongTargets()) {
            $arguments[] = "-longtargets";
        }

        if ($options->getList()) {
            $arguments[] = "-list";
        }

        foreach ($options->getProperties() as $key => $value) {
            $arguments[] = sprintf("-D%s=%s", (string) $key, (string) escapeshellarg($value));
        }

        return $arguments;
    }
}
