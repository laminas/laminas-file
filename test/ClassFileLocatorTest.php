<?php

/**
 * @see       https://github.com/laminas/laminas-file for the canonical source repository
 * @copyright https://github.com/laminas/laminas-file/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-file/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\File;

use Laminas\File\ClassFileLocator;

/**
 * Test class for Laminas\File\ClassFileLocator
 *
 * @group      Laminas_File
 */
class ClassFileLocatorTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructorThrowsInvalidArgumentExceptionForInvalidStringDirectory()
    {
        $this->setExpectedException('Laminas\File\Exception\InvalidArgumentException');
        $locator = new ClassFileLocator('__foo__');
    }

    public function testConstructorThrowsInvalidArgumentExceptionForNonDirectoryIteratorArgument()
    {
        $iterator = new \ArrayIterator(array());
        $this->setExpectedException('Laminas\File\Exception\InvalidArgumentException');
        $locator = new ClassFileLocator($iterator);
    }

    public function testIterationShouldReturnOnlyPhpFiles()
    {
        $locator = new ClassFileLocator(__DIR__);
        foreach ($locator as $file) {
            $this->assertRegexp('/\.php$/', $file->getFilename());
        }
    }

    public function testIterationShouldReturnOnlyPhpFilesContainingClasses()
    {
        $locator = new ClassFileLocator(__DIR__);
        $found = false;
        foreach ($locator as $file) {
            if (preg_match('/locator-should-skip-this\.php$/', $file->getFilename())) {
                $found = true;
            }
        }
        $this->assertFalse($found, "Found PHP file not containing a class?");
    }

    public function testIterationShouldReturnInterfaces()
    {
        $locator = new ClassFileLocator(__DIR__);
        $found = false;
        foreach ($locator as $file) {
            if (preg_match('/LocatorShouldFindThis\.php$/', $file->getFilename())) {
                $found = true;
            }
        }
        $this->assertTrue($found, "Locator skipped an interface?");
    }

    public function testIterationShouldInjectNamespaceInFoundItems()
    {
        $locator = new ClassFileLocator(__DIR__);
        $found = false;
        foreach ($locator as $file) {
            $classes = $file->getClasses();
            foreach ($classes as $class) {
                if (strpos($class, '\\', 1)) {
                    $found = true;
                }
            }
        }
        $this->assertTrue($found);
    }

    public function testIterationShouldInjectNamespacesInFileInfo()
    {
        $locator = new ClassFileLocator(__DIR__);
        foreach ($locator as $file) {
            $namespaces = $file->getNamespaces();
            $this->assertTrue(count($namespaces) > 0);
        }
    }

    public function testIterationShouldInjectClassInFoundItems()
    {
        $locator = new ClassFileLocator(__DIR__);
        $found = false;
        foreach ($locator as $file) {
            $classes = $file->getClasses();
            foreach ($classes as $class) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found);
    }

    public function testIterationShouldFindMultipleClassesInMultipleNamespacesInSinglePhpFile()
    {
        $locator = new ClassFileLocator(__DIR__);
        $foundFirst = false;
        $foundSecond = false;
        $foundThird = false;
        $foundFourth = false;
        foreach ($locator as $file) {
            if (preg_match('/MultipleClassesInMultipleNamespaces\.php$/', $file->getFilename())) {
                $classes = $file->getClasses();
                foreach ($classes as $class) {
                    if ($class === 'LaminasTest\File\TestAsset\LocatorShouldFindFirstClass') {
                        $foundFirst = true;
                    }
                    if ($class === 'LaminasTest\File\TestAsset\LocatorShouldFindSecondClass') {
                        $foundSecond = true;
                    }
                    if ($class === 'LaminasTest\File\TestAsset\SecondTestNamespace\LocatorShouldFindThirdClass') {
                        $foundThird = true;
                    }
                    if ($class === 'LaminasTest\File\TestAsset\SecondTestNamespace\LocatorShouldFindFourthClass') {
                        $foundFourth = true;
                    }
                }
            }
        }
        $this->assertTrue($foundFirst);
        $this->assertTrue($foundSecond);
        $this->assertTrue($foundThird);
        $this->assertTrue($foundFourth);
    }
}
