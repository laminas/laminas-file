<?php

/**
 * @see       https://github.com/laminas/laminas-file for the canonical source repository
 * @copyright https://github.com/laminas/laminas-file/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-file/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\File\Transfer\Adapter;

use Laminas\Filter\FilterPluginManager as BaseManager;

/**
 * Plugin manager implementation for the filter chain.
 *
 * Enforces that filters retrieved are instances of
 * FilterInterface. Additionally, it registers a number of default filters.
 *
 */
class FilterPluginManager extends BaseManager
{
    /**
     * Default set of filters
     *
     * @var array
     */
    protected $aliases = array(
        'decrypt'   => 'filedecrypt',
        'encrypt'   => 'fileencrypt',
        'lowercase' => 'filelowercase',
        'rename'    => 'filerename',
        'uppercase' => 'fileuppercase',
    );
}
