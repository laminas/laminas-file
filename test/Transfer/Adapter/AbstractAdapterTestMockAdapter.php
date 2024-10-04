<?php

declare(strict_types=1);

namespace LaminasTest\File\Transfer\Adapter;

use Laminas\File\Transfer\Adapter;

/**
 * Test class for Laminas\File\Transfer\Adapter\AbstractAdapter
 *
 * @group      Laminas_File
 */
class AbstractAdapterTestMockAdapter extends Adapter\AbstractAdapter
{
    public bool $received = false;

    /**
     * Temp Directory
     *
     * @var string
     */
    public $tmpDir;

    public function __construct()
    {
        $testfile    = __DIR__ . '/_files/test.txt';
        $this->files = [
            'foo'     => [
                'name'      => 'foo.jpg',
                'type'      => 'image/jpeg',
                'size'      => 126976,
                'tmp_name'  => '/tmp/489127ba5c89c',
                'options'   => ['ignoreNoFile' => false, 'useByteString' => true, 'detectInfos' => true],
                'validated' => false,
                'received'  => false,
                'filtered'  => false,
            ],
            'bar'     => [
                'name'      => 'bar.png',
                'type'      => 'image/png',
                'size'      => 91136,
                'tmp_name'  => '/tmp/489128284b51f',
                'options'   => ['ignoreNoFile' => false, 'useByteString' => true],
                'validated' => false,
                'received'  => false,
                'filtered'  => false,
            ],
            'baz'     => [
                'name'      => 'baz.text',
                'type'      => 'text/plain',
                'size'      => 1172,
                'tmp_name'  => $testfile,
                'options'   => ['ignoreNoFile' => false, 'useByteString' => true],
                'validated' => false,
                'received'  => false,
                'filtered'  => false,
            ],
            'file_0_' => [
                'name'      => 'foo.jpg',
                'type'      => 'image/jpeg',
                'size'      => 126976,
                'tmp_name'  => '/tmp/489127ba5c89c',
                'options'   => ['ignoreNoFile' => false, 'useByteString' => true],
                'validated' => false,
                'received'  => false,
                'filtered'  => false,
            ],
            'file_1_' => [
                'name'      => 'baz.text',
                'type'      => 'text/plain',
                'size'      => 1172,
                'tmp_name'  => $testfile,
                'options'   => ['ignoreNoFile' => false, 'useByteString' => true],
                'validated' => false,
                'received'  => false,
                'filtered'  => false,
            ],
            'file'    => [
                'name'       => 'foo.jpg',
                'multifiles' => [0 => 'file_0_', 1 => 'file_1_'],
            ],
        ];
    }

    /**
     * Send Function
     *
     * @param mixed $options
     */
    public function send($options = null): void
    {
        // No need for a return statement here since the return type is void
    }

    /**
     * Receive Function
     *
     * @param mixed $options
     */
    public function receive($options = null): void
    {
        $this->received = true;
        // No need for a return statement here since the return type is void
    }

    /**
     * Is Sent
     *
     * @param mixed $file
     * @return bool
     */
    public function isSent($file = null)
    {
        return false;
    }

    /**
     * Is Received
     *
     * @param mixed $file
     * @return bool
     */
    public function isReceived($file = null)
    {
        return $this->received;
    }

    /**
     * Is Uploaded
     *
     * @param mixed $files
     * @return bool
     */
    public function isUploaded($files = null)
    {
        return true;
    }

    /**
     * Is Filtered
     *
     * @return bool
     */
    public function isFiltered(mixed $files = null)
    {
        return true;
    }

    /**
     * Get Progress
     */
    public static function getProgress(): void
    {
        // No need for a return statement here since the return type is void
    }

    /**
     * Get Temp Dir
     *
     * @return void
     */
    public function getTmpDir()
    {
        $this->tmpDir = parent::getTmpDir();
    }

    /**
     * Is Path Writeable
     *
     * @param string $path
     * @return bool
     */
    public function isPathWriteable($path)
    {
        return parent::isPathWriteable($path);
    }

    public function addInvalidFile()
    {
        $this->files += [
            'test' => [
                'name'      => 'test.txt',
                'type'      => 'image/jpeg',
                'size'      => 0,
                'tmp_name'  => '',
                'options'   => ['ignoreNoFile' => true, 'useByteString' => true],
                'validated' => false,
                'received'  => false,
                'filtered'  => false,
            ],
        ];
    }
}
