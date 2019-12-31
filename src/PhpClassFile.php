<?php

/**
 * @see       https://github.com/laminas/laminas-file for the canonical source repository
 * @copyright https://github.com/laminas/laminas-file/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-file/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\File;

use SplFileInfo;

/**
 * Locate files containing PHP classes, interfaces, abstracts or traits
 */
class PhpClassFile extends SplFileInfo
{
    /**
     * @var array
     */
    protected $classes = [];

    /**
     * @var array
     */
    protected $namespaces = [];

    /**
     * Get classes
     *
     * @return array
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Get namespaces
     *
     * @return array
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * Add class
     *
     * @param  string $class
     * @return self
     */
    public function addClass($class)
    {
        $this->classes[] = $class;
        return $this;
    }

    /**
     * Add namespace
     *
     * @param  string $namespace
     * @return self
     */
    public function addNamespace($namespace)
    {
        if (in_array($namespace, $this->namespaces)) {
            return $this;
        }
        $this->namespaces[] = $namespace;
        return $this;
    }
}
