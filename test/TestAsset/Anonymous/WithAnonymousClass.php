<?php

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

