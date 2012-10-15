<?php

namespace BsbPhingService\Service;

use BsbPhingService\Options\Service as ServiceOptions;
use BsbPhingService\Options\Phing as PhingOptions;

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
        $this->options = $options;
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
     * @param type $target
     * @param null|array|Traversable $options
     * @return type
     */
    public function build($target = null, $options = null)
    {
        $phingOptions = clone $this->phingOptions;

        if ($options) {
            if (!is_array($options) && !$options instanceof Traversable) {
                throw new \InvalidArgumentException(sprintf(
                                'Parameter provided to %s must be an array or Traversable', __METHOD__
                ));
            }

            $phingOptions->setFromArray($options);
        }

        return $this->doBuild($target, $phingOptions);
    }

    protected function doBuild($target, PhingOptions $options)
    {
        if (!self::hasExec()) {
            throw new \RuntimeException("Not able to use PHP's exec method");
        }

        $commands = $this->getEnvironmentCommands();

        $commands[] = sprintf("%s %s \\\n      %s 2>&1 ", $this->options->getPhingBin(), implode(" \\\n      ", $this->getPhingCommandArgumentsArray($options)), $target);

        $command = implode(" && \\\n", $commands);

        exec($command, $output, $return_status);

        return Array('command'      => $command, 'output'       => implode(PHP_EOL, $output), 'returnStatus' => $return_status);
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
     * @return Array
     */
    protected function getEnvironmentCommands()
    {
        $commands = array();

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $commands[] = sprintf('set PHP_COMMAND=%s', $this->options->getPhpBin());
            $commands[] = sprintf('set PHING_HOME=%s', $this->options->getPhingPath());
            $commands[] = sprintf('set PHP_CLASSPATH=%s\classes', $this->options->getPhingPath());
            $commands[] = 'set PATH=%PATH%;%PHING_HOME%\bin';
        } else {
            $commands[] = sprintf('export PHP_COMMAND=%s', $this->options->getPhpBin());
            $commands[] = sprintf('export PHING_HOME=%s', $this->options->getPhingPath());
            $commands[] = 'export PHP_CLASSPATH=${PHING_HOME}/classes';
            $commands[] = 'export PATH=${PATH}:${PHING_HOME}/bin';
        }

        return $commands;
    }

    /**
     * Construct an array with arguments to configure the phing binary
     *
     * @param PhingOptions $options
     * @return type
     */
    protected function getPhingCommandArgumentsArray(PhingOptions $options)
    {
        $arguments = array();

        if ($options->getBuildFile()) {
            $arguments[] = sprintf("-buildfile %s", escapeshellarg($options->getBuildFile()));
        }

        if ($options->getLogger()) {
            $arguments[] = sprintf("-logger %s", escapeshellarg($options->getLogger()));
        }

        if ($options->getLogFile()) {
            $arguments[] = sprintf("-logfile %s", escapeshellarg($options->getLogFile()));
        }

        if ($options->getPropertyFile()) {
            $arguments[] = sprintf("-propertyfile %s", escapeshellarg($options->getPropertyFile()));
        }

        if ($options->getInputHandler()) {
            $arguments[] = sprintf("-inputhandler %s", escapeshellarg($options->getInputHandler()));
        }

        if ($options->getFind()) {
            $arguments[] = sprintf("-find %s", escapeshellarg($options->getFind()));
        }

        if ($options->getLongTargets()) {
            $arguments[] = "-longtargets";
        }

        if ($options->getList()) {
            $arguments[] = "-list";
        }

        foreach ($options->getProperties() AS $key => $value) {
            $arguments[] = sprintf("-D%s=%s", (string) $key, (string) escapeshellarg($value));
        }

        return $arguments;
    }

}
