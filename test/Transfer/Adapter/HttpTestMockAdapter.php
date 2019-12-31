<?php

/**
 * @see       https://github.com/laminas/laminas-file for the canonical source repository
 * @copyright https://github.com/laminas/laminas-file/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-file/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\File\Transfer\Adapter;

use Laminas\File\Transfer\Adapter;

/**
 * Test class for Laminas\File\Transfer\Adapter\AbstractAdapter
 *
 * @group      Laminas_File
 */
class HttpTestMockAdapter extends Adapter\Http
{
    public function __construct()
    {
        self::$callbackApc = ['LaminasTest\File\Transfer\Adapter\HttpTestMockAdapter', 'apcTest'];
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
        return [
            'total' => 100,
            'current' => 100,
            'rate' => 10,
        ];
    }

    public static function uPTest($id)
    {
        return [
            'bytes_total' => 100,
            'bytes_uploaded' => 100,
            'speed_average' => 10,
            'cancel_upload' => true,
        ];
    }

    public function switchApcToUP()
    {
        self::$callbackApc = null;
        self::$callbackUploadProgress = ['LaminasTest\File\Transfer\Adapter\HttpTestMockAdapter', 'uPTest'];
    }
}
