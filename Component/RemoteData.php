<?php

namespace Adadgio\HealthBundle\Component;

class RemoteData
{
    /**
     * @var string Base resource path
     */
    private $basePath = 'https://raw.githubusercontent.com/adadgio/data-bundle/master/Resources/%s/%s/%s/data_%s.%s';

    /**
     * @var string Resource final remote path
     */
    private $path;
    
    /**
     * var string Cache directory
     */
    private $cacheDir;

    /**
     * Set cache dir. Activates the cache.
     *
     * @param string Server directory full path.
     * @return \DataAccess
     */
    public function setCacheDir()
    {
        $this->cacheDir = rtrim($dir, '/');

        return $this;
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
        $cachedFile = $this->cacheDir.'/'.basename($this->path);

        if (null !== $this->cacheDir && is_file($cachedFile)) {
            return file_get_contents($cachedFile);

        } else {

            $contents = file_get_contents($this->path);

            if (null !== $contents) {
                file_put_contents($cachedFile, $contents);
            }

            return $content;
        }


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

        return $this;
    }
}
