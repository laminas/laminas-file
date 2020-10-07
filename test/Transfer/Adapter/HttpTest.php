<?php

/**
 * @see       https://github.com/laminas/laminas-file for the canonical source repository
 * @copyright https://github.com/laminas/laminas-file/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-file/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\File\Transfer\Adapter;

use Laminas\File\Transfer\Adapter;
use Laminas\File\Transfer\Exception\BadMethodCallException;
use Laminas\File\Transfer\Exception\RuntimeException;
use Laminas\ProgressBar;
use Laminas\Validator;
use PHPUnit\Framework\TestCase;

/**
 * Test class for Laminas\File\Transfer\Adapter\Http
 *
 * @group      Laminas_File
 */
class HttpTest extends TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp(): void
    {
        $_FILES = [
            'txt' => [
                'name' => 'test.txt',
                'type' => 'plain/text',
                'size' => 8,
                'tmp_name' => __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'php0zgByO',
                'error' => 0,
            ],
        ];
        $this->adapter = new HttpTestMockAdapter();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown(): void
    {
    }

    public function testEmptyAdapter()
    {
        $files = $this->adapter->getFileName();
        $this->assertStringContainsString('php0zgByO_test.txt', $files);
    }

    public function testAutoSetUploadValidator()
    {
        $validators = [
            new Validator\File\Count(1),
            new Validator\File\Extension('jpg'),
        ];
        $this->adapter->setValidators($validators);
        $test = $this->adapter->getValidator('Upload');
        $this->assertInstanceOf(Validator\File\Upload::class, $test);
    }

    public function testSendingFiles()
    {
        $this->expectException(BadMethodCallException::class, 'not implemented');

        $this->adapter->send();
    }

    public function testFileIsSent()
    {
        $this->expectException(BadMethodCallException::class, 'not implemented');

        $this->adapter->isSent();
    }

    public function testFileIsUploaded()
    {
        $this->assertTrue($this->adapter->isUploaded());
    }

    public function testFileIsNotUploaded()
    {
        $this->assertFalse($this->adapter->isUploaded('unknownFile'));
    }

    public function testFileIsNotFiltered()
    {
        $this->assertFalse($this->adapter->isFiltered('unknownFile'));
        $this->assertFalse($this->adapter->isFiltered());
    }

    public function testFileIsNotReceived()
    {
        $this->assertFalse($this->adapter->isReceived('unknownFile'));
        $this->assertFalse($this->adapter->isReceived());
    }

    public function testReceiveUnknownFile()
    {
        try {
            $this->assertFalse($this->adapter->receive('unknownFile'));
        } catch (RuntimeException $e) {
            $this->assertStringContainsString('not find', $e->getMessage());
        }
    }

    public function testReceiveValidatedFile()
    {
        $_FILES = [
            'txt' => [
                'name' => 'unknown.txt',
                'type' => 'plain/text',
                'size' => 8,
                'tmp_name' => 'unknown.txt',
                'error' => 0,
            ],
        ];
        $adapter = new HttpTestMockAdapter();
        $this->assertFalse($adapter->receive());
    }

    public function testReceiveIgnoredFile()
    {
        $this->adapter->setOptions(['ignoreNoFile' => true]);
        $this->assertTrue($this->adapter->receive());
    }

    public function testReceiveWithRenameFilter()
    {
        $this->adapter->addFilter('Rename', ['target' => '/testdir']);
        $this->adapter->setOptions(['ignoreNoFile' => true]);
        $this->assertTrue($this->adapter->receive());
    }

    public function testReceiveWithRenameFilterButWithoutDirectory()
    {
        $this->adapter->setDestination(__DIR__);
        $this->adapter->addFilter('Rename', ['overwrite' => false]);
        $this->adapter->setOptions(['ignoreNoFile' => true]);
        $this->assertTrue($this->adapter->receive());
    }

    public function testMultiFiles()
    {
        $_FILES = [
            'txt' => [
                'name' => 'test.txt',
                'type' => 'plain/text',
                'size' => 8,
                'tmp_name' => __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'php0zgByO',
                'error' => 0,
            ],
            'exe' => [
                'name' => [
                    0 => 'file1.exe',
                    1 => 'file2.exe',
                ],
                'type' => [
                    0 => 'plain/text',
                    1 => 'plain/text',
                ],
                'size' => [
                    0 => 8,
                    1 => 8,
                ],
                'tmp_name' => [
                    0 => __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'phpqBXGTg',
                    1 => __DIR__ . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'phpZqRDQF',
                ],
                'error' => [
                    0 => 0,
                    1 => 0,
                ],
            ],
        ];
        $adapter = new HttpTestMockAdapter();
        $adapter->setOptions(['ignoreNoFile' => true]);
        $this->assertTrue($adapter->receive('exe'));
        $this->assertEquals([
            'exe_0_' => 'phpqBXGTg_file1.exe',
            'exe_1_' => 'phpZqRDQF_file2.exe',
        ], $adapter->getFileName('exe', false));
    }

    public function testMultiFilesSameName()
    {
        $_FILES = [
            'txt' => [
                'name' => 'test.txt',
                'type' => 'plain/text',
                'size' => 8,
                'tmp_name' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'php0zgByO',
                'error' => 0,
            ],
            'exe' => [
                'name' => [
                    0 => 'file.exe',
                    1 => 'file.exe',
                ],
                'type' => [
                    0 => 'plain/text',
                    1 => 'plain/text',
                ],
                'size' => [
                    0 => 8,
                    1 => 8,
                ],
                'tmp_name' => [
                    0 => dirname(__FILE__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'phpOOwDDc',
                    1 => dirname(__FILE__) . DIRECTORY_SEPARATOR . '_files' . DIRECTORY_SEPARATOR . 'phpDlIxkx',
                ],
                'error' => [
                    0 => 0,
                    1 => 0,
                ],
            ],
        ];
        $adapter = new HttpTestMockAdapter();
        $adapter->setOptions(['ignoreNoFile' => true]);
        $this->assertTrue($adapter->receive('exe'));
        $this->assertEquals([
            'exe_0_' => 'phpOOwDDc_file.exe',
            'exe_1_' => 'phpDlIxkx_file.exe',
        ], $adapter->getFileName('exe', false));
    }

    public function testNoUploadInProgress()
    {
        if (! Adapter\Http::isApcAvailable() && ! Adapter\Http::isUploadProgressAvailable()) {
            $this->markTestSkipped('Whether APC nor UploadExtension available');
        }

        $status = HttpTestMockAdapter::getProgress();
        $this->assertContains('No upload in progress', $status);
    }

    public function testUploadProgressFailureForAPC()
    {
        if (! Adapter\Http::isApcAvailable()) {
            $this->markTestSkipped('APC extension is unavailable');
        }

        $_GET['progress_key'] = 'mykey';
        $status = HttpTestMockAdapter::getProgress();
        $this->assertEquals([
            'total'   => 100,
            'current' => 100,
            'rate'    => 10,
            'id'      => 'mykey',
            'done'    => false,
            'message' => '100B - 100B',
        ], $status);
    }

    public function testUploadProgressFailureForUploadProgressExtension()
    {
        if (! Adapter\Http::isUploadProgressAvailable()) {
            $this->markTestSkipped('uploadprogress extension is unavailable');
        }

        $_GET['progress_key'] = 'mykey';
        $this->adapter->switchApcToUP();

        $status = HttpTestMockAdapter::getProgress();
        $this->assertEquals([
            'total'   => 100,
            'current' => 90,
            'rate'    => 10,
            'id'      => 'mykey',
            'done'    => false,
            'message' => '90B - 100B',
        ], $status);

        $this->adapter->forceUPFailure();
        $status = HttpTestMockAdapter::getProgress($status);
        $this->assertEquals([
            'total'          => 100,
            'bytes_total'    => 100,
            'current'        => 100,
            'bytes_uploaded' => 100,
            'rate'           => 10,
            'speed_average'  => 10,
            'cancel_upload'  => true,
            'message'        => 'The upload has been canceled',
            'done'           => true,
            'id'             => 'mykey',
        ], $status);
    }

    public function testUploadProgressAdapter()
    {
        if (! Adapter\Http::isApcAvailable() && ! Adapter\Http::isUploadProgressAvailable()) {
            $this->markTestSkipped('Whether APC nor UploadExtension available');
        }

        $_GET['progress_key'] = 'mykey';
        $adapter = new ProgressBar\Adapter\Console();
        $status = ['progress' => $adapter, 'session' => 'upload'];
        $status = HttpTestMockAdapter::getProgress($status);
        $this->assertArrayHasKey('total', $status);
        $this->assertArrayHasKey('current', $status);
        $this->assertArrayHasKey('rate', $status);
        $this->assertArrayHasKey('id', $status);
        $this->assertArrayHasKey('message', $status);
        $this->assertArrayHasKey('progress', $status);
        $this->assertInstanceOf(ProgressBar\ProgressBar::class, $status['progress']);

        $this->adapter->switchApcToUP();
        $status = HttpTestMockAdapter::getProgress($status);
        $this->assertArrayHasKey('total', $status);
        $this->assertArrayHasKey('current', $status);
        $this->assertArrayHasKey('rate', $status);
        $this->assertArrayHasKey('id', $status);
        $this->assertArrayHasKey('message', $status);
        $this->assertArrayHasKey('progress', $status);
        $this->assertInstanceOf(ProgressBar\ProgressBar::class, $status['progress']);
    }

    public function testValidationOfPhpExtendsFormError()
    {
        $_SERVER['CONTENT_LENGTH'] = 10;

        $_FILES = [];
        $adapter = new HttpTestMockAdapter();
        $this->assertFalse($adapter->isValidParent());
        $this->assertStringContainsString('exceeds', current($adapter->getMessages()));
    }
}
