<?php

/**
 * @see       https://github.com/laminas/laminas-file for the canonical source repository
 * @copyright https://github.com/laminas/laminas-file/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-file/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\File\TestAsset\Anonymous;

final class WithAnonymousClass
{
    private $anonymous;

    public function __construct()
    {
        $this->anonymous = new class extends \stdClass {

        };
    }
}

