<?php

declare(strict_types=1);

namespace LaminasTest\File\Transfer\Adapter;

use Laminas\File\Transfer\Adapter;

use function is_array;

/**
 * Test class for Laminas\File\Transfer\Adapter\AbstractAdapter
 *
 * @group      Laminas_File
 */
class HttpTestMockAdapter extends Adapter\Http
{
    private static bool $uploadProgressShouldFail;

    public function __construct()
    {
        static::$callbackApc            = [self::class, 'apcTest'];
        self::$uploadProgressShouldFail = false;
        parent::__construct();
    }

    public function isValid(mixed $files = null): bool
    {
        return true;
    }

    public function isValidParent(mixed $files = null): bool
    {
        return parent::isValid($files);
    }

    public static function isApcAvailable(): bool
    {
        return true;
    }

    /**
     * Apc Test
     *
     * @param mixed $id
     * @return int[]
     */
    public static function apcTest($id): array
    {
        if (! is_array($id)) {
            return [
                'total'   => 100,
                'current' => 100,
                'rate'    => 10,
            ];
        }

        return [
            'bytes_total'    => 100,
            'bytes_uploaded' => 100,
            'speed_average'  => 10,
            'cancel_upload'  => true,
        ];
    }

    /**
     * uPTest
     *
     * @param mixed $id
     * @return int[]
     */
    public static function uPTest($id): array
    {
        if (! self::$uploadProgressShouldFail) {
            return [
                'total'   => 100,
                'current' => 90,
                'rate'    => 10,
            ];
        }

        return [
            'bytes_total'    => 100,
            'bytes_uploaded' => 100,
            'speed_average'  => 10,
            'cancel_upload'  => true,
        ];
    }

    public function switchApcToUP()
    {
        static::$callbackApc            = null;
        static::$callbackUploadProgress = [self::class, 'uPTest'];
    }

    public function forceUPFailure()
    {
        self::$uploadProgressShouldFail = true;
    }
}
