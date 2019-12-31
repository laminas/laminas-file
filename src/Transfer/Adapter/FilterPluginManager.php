<?php

/**
 * @see       https://github.com/laminas/laminas-file for the canonical source repository
 * @copyright https://github.com/laminas/laminas-file/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-file/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\File\Transfer\Adapter;

use Laminas\Filter\File;
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
     * Constructor
     *
     * Merges default aliases pertinent to this plugin manager with those
     * defined in the parent filter plugin manager.
     *
     * @param null|\Laminas\ServiceManager\ConfigInterface|\Interop\Container\ContainerInterface $configOrContainerInstance
     * @param array $v3config If $configOrContainerInstance is a container, this
     *     value will be passed to the parent constructor.
     */
    public function __construct($configOrContainerInstance = null, array $v3config = [])
    {
        $this->aliases = array_merge([
            'decrypt'       => File\Decrypt::class,
            'encrypt'       => File\Encrypt::class,
            'lowercase'     => File\LowerCase::class,
            'rename'        => File\Rename::class,
            'uppercase'     => File\UpperCase::class,
        ], $this->aliases);

        parent::__construct($configOrContainerInstance, $v3config);
    }
}
