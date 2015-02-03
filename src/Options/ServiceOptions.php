<?php

namespace BsbPhingService\Options;

use RuntimeException;
use Symfony\Component\Process\ProcessBuilder;
use Zend\Stdlib\AbstractOptions;

class ServiceOptions extends AbstractOptions
{

    /**
     * Path to php binary
     *
     * @var string
     */
    private $phpBin = null;

    /**
     * Path to phing binary
     *
     * @var string
     */
    private $phingBin = null;

    /**
     * @param array $options
     */
    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }

    /**
     * Sets the php executable
     *
     * Set it with a value of 'null' to automaticly discover the path
     *
     * @param null $path
     */
    public function setPhpBin($path = null)
    {
        $this->phpBin = $path;
    }

    /**
     * Get the path to the php executable
     *
     * Attempt auto discovery via 'which php' if null
     *
     * @return string
     */
    public function getPhpBin()
    {
        if ($this->phpBin === null) {
            $builder = new ProcessBuilder();
            $builder->setPrefix('which');
            $builder->setArguments(array('php'));

            $process = $builder->getProcess();
            $process->run();

            if ($process->getExitCodeText() == 'OK') {
                $this->phpBin = trim($process->getOutput());
            }
        }

        return $this->phpBin;
    }

    /**
     * Set path to the phing binary
     *
     * @param string $phingBin
     */
    public function setPhingBin($phingBin = null)
    {
        $this->phingBin = $phingBin;
    }

    /**
     * Get path to the phing binary
     *
     * Attempt auto discovery from composer if null
     *
     * @return string
     */
    public function getPhingBin()
    {
        if ($this->phingBin === null && file_exists('./composer.json')) {
            @$composer = json_decode(file_get_contents('./composer.json'), true);
            if (isset($composer['bin-dir'])) {
                $this->phingBin = $composer['bin-dir'] . '/phing';
            }
        }

        if ($this->phingBin === null && getenv('COMPOSER_BIN_DIR') !== false) {
            $this->phingBin = getenv('COMPOSER_BIN_DIR') . '/phing';
        }

        if ($this->phingBin === null) {
            $this->phingBin = './vendor/bin/phing';
        }

        return $this->phingBin;
    }
}
