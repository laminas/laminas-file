<?php

namespace LaminasTest\File\TestAsset;

use stdClass;

class ClassNameResolutionCompatibility
{
    protected $someClassNames = [
        stdClass::class,
        stdClass::class,
    ];
}
