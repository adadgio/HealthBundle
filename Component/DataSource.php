<?php

namespace Adadgio\HealthBundle\Component;

class DataSource
{
    /**
     * @var string Base resource path
     */
    private $basePath;

    /**
     * @var string Resource final remote path
     */
    private $path;

    /**
     * var string Cache directory
     */
    //private $cacheDir;

    /**
     * @var string Symfiny version
     */
    //protected $sfVersion;

    /**
     * Constructor.
     */
    public function __construct($kernelRootDir)
    {
        //$this->cacheDir = null;
        //$this->sfVersion = \Symfony\Component\HttpKernel\Kernel::VERSION;
        $this->basePath = __DIR__.'/../Resources/%s/%s/%s/data_%s.%s';
    }

    /**
     * Get main version number.
     *
     * @return integer Main release version number
     */
    protected function firstVersionNumber()
    {
        $vs = explode('.', $this->sfVersion);

        return (int) end($vs);
    }

    /**
     * Get path.
     *
     * @return string Path
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Get source contents.
     *
     * @return string
     */
    public function getContents()
    {
        return file_get_contents($this->path);
    }

    /**
     * Get a resource
     *
     * @return
     */
    public function find($alias, $year, $format, $lang = null)
    {
        $namespace = str_replace(':', '/', $alias);

        $this->path = sprintf($this->basePath,
            $namespace, $year, $format, $lang, $format
        );

        if (!is_file($this->path)) {
            throw new \Exception(sprintf('Requested data source "%s" does not exist at path "%s"', basename($this->path), $this->path));
        }

        return $this;
    }
}
