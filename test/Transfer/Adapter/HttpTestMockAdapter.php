<?php

namespace LaminasTest\File\Transfer\Adapter;

use Laminas\File\Transfer\Adapter;

/**
 * Test class for Laminas\File\Transfer\Adapter\AbstractAdapter
 *
 * @group      Laminas_File
 */
class HttpTestMockAdapter extends Adapter\Http
{
    private static $uploadProgressShouldFail;

    public function __construct()
    {
        static::$callbackApc = [HttpTestMockAdapter::class, 'apcTest'];
        self::$uploadProgressShouldFail = false;
        parent::__construct();
    }

    public function isValid($files = null)
    {
        return true;
    }

    public function isValidParent($files = null)
    {
        return parent::isValid($files);
    }

    public static function isApcAvailable()
    {
        return true;
    }

    public static function apcTest($id)
    {
        if (! is_array($id)) {
            return [
                'total' => 100,
                'current' => 100,
                'rate' => 10,
            ];
        }

        return [
            'bytes_total' => 100,
            'bytes_uploaded' => 100,
            'speed_average' => 10,
            'cancel_upload' => true,
        ];
    }

    public static function uPTest($id)
    {
        if (! self::$uploadProgressShouldFail) {
            return [
                'total' => 100,
                'current' => 90,
                'rate' => 10,
            ];
        }

        return [
            'bytes_total' => 100,
            'bytes_uploaded' => 100,
            'speed_average' => 10,
            'cancel_upload' => true,
        ];
    }

    public function switchApcToUP()
    {
        static::$callbackApc = null;
        static::$callbackUploadProgress = [HttpTestMockAdapter::class, 'uPTest'];
    }

    public function forceUPFailure()
    {
        self::$uploadProgressShouldFail = true;
    }
}
