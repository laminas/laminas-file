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
 *
 * @category   Laminas
 * @package    Laminas_File
 */
class PhpClassFile extends SplFileInfo
{
    /**
     * @var array
     */
    protected $classes;

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
     * Add class
     *
     * @param string $class
     * @return PhpClassFile
     */
    public function addClass($class)
    {
        $this->classes[] = $class;
        return $this;
    }
}
