<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\File\Transfer\Adapter;

use Zend\Filter\FilterPluginManager as BaseManager;
use Zend\Filter\File;

/**
 * Plugin manager implementation for the filter chain.
 *
 * Enforces that filters retrieved are instances of
 * FilterInterface. Additionally, it registers a number of default filters.
 *
 */
class FilterPluginManager extends BaseManager
{

    public function __construct($configOrContainerInstance = null, array $v3config = []) 
    {
	parent::__construct($configOrContainerInstance, $v3config);
        
	$this->aliases = array_merge(array(
            'decrypt'       => File\Decrypt::class,
            'encrypt'       => File\Encrypt::class,
            'lowercase'     => File\LowerCase::class,
            'rename'        => File\Rename::class,
            'uppercase'     => File\UpperCase::class
        ), $this->aliases);
    }

}

