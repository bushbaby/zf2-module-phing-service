<?php

namespace BsbPhingService\Service;

use BsbPhingService\Options\PhingOptions;
use BsbPhingService\Options\ServiceOptions;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use Traversable;

class PhingService
{

    /**
     * @var ServiceOptions
     */
    protected $options;

    /**
     * @var PhingOptions
     */
    protected $phingOptions;

    /**
     * @param ServiceOptions $options
     * @param PhingOptions   $phingOptions
     */
    public function __construct(ServiceOptions $options, PhingOptions $phingOptions)
    {
        $this->options      = $options;
        $this->phingOptions = $phingOptions;
    }

    /**
     * @return ServiceOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return PhingOptions
     */
    public function getPhingOptions()
    {
        return $this->phingOptions;
    }

    /**
     * Configure phing and run a build.
     *
     * @param string                 $targets   space separated list of targets
     * @param null|array|Traversable $options   override the default phing options
     * @param bool                   $immediate call run on the process instance, set to false if you need to do
     *                                          advanced process management
     *
     * @return Process
     */
    public function build($targets = "", $options = null, $immediate = true)
    {
        $phingOptions = clone $this->phingOptions;

        if ($options !== null) {
            $phingOptions->setFromArray($options);
        }

        $process = $this->createProcessInstance($targets, $phingOptions);

        if ($immediate) {
            $process->run();
        }

        return $process;
    }

    /**
     * Constructs a configured Process instance
     *
     * @param string       $targets space separated list of targets
     * @param PhingOptions $options
     *
     * @return Process
     */
    private function createProcessInstance($targets, PhingOptions $options)
    {
        $builder = new ProcessBuilder();

        $builder->setPrefix($this->options->getPhingBin());
        $builder->setArguments($options->toArgumentsArray());

        foreach (explode(' ', $targets) as $target) {
            if (strlen(trim($target))) {
                $builder->add(trim($target));
            }
        }

        return $builder->getProcess();
    }
}
