<?php

namespace LaminasTest\File;

use Laminas\File\ClassFileLocator;
use Laminas\File\Exception;
use Laminas\File\PhpClassFile;
use PHPUnit\Framework\TestCase;

class ClassFileLocatorTest extends TestCase
{
    public function testConstructorThrowsInvalidArgumentExceptionForInvalidStringDirectory()
    {
        $this->expectException(Exception\InvalidArgumentException::class);

        $locator = new ClassFileLocator('__foo__');
    }

    public function testConstructorThrowsInvalidArgumentExceptionForNonDirectoryIteratorArgument()
    {
        $iterator = new \ArrayIterator([]);

        $this->expectException(Exception\InvalidArgumentException::class);

        $locator = new ClassFileLocator($iterator);
    }

    public function testIterationShouldReturnOnlyPhpFiles()
    {
        $locator = new ClassFileLocator(__DIR__);
        foreach ($locator as $file) {
            $this->assertMatchesRegularExpression('/\.php$/', $file->getFilename());
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
            $this->assertNotEmpty($namespaces);
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
                    if ($class === TestAsset\LocatorShouldFindFirstClass::class) {
                        $foundFirst = true;
                    }
                    if ($class === TestAsset\LocatorShouldFindSecondClass::class) {
                        $foundSecond = true;
                    }
                    if ($class === TestAsset\SecondTestNamespace\LocatorShouldFindThirdClass::class) {
                        $foundThird = true;
                    }
                    if ($class === TestAsset\SecondTestNamespace\LocatorShouldFindFourthClass::class) {
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

    /**
     * @group 6946
     * @group 6814
     */
    public function testIterationShouldNotCountFQCNScalarResolutionConstantAsClass()
    {
        foreach (new ClassFileLocator(__DIR__ .'/TestAsset') as $file) {
            if (! preg_match('/ClassNameResolutionCompatibility\.php$/', $file->getFilename())) {
                continue;
            }
            $this->assertCount(1, $file->getClasses());
        }
    }

    /**
     * @requires PHP 7.1
     */
    public function testIgnoresAnonymousClasses()
    {
        $classFileLocator = new ClassFileLocator(__DIR__ . '/TestAsset/Anonymous');

        $classFiles = \iterator_to_array($classFileLocator);

        $this->assertCount(1, $classFiles);

        $classNames = \array_reduce($classFiles, function (array $classNames, PhpClassFile $classFile) {
            return \array_merge(
                $classNames,
                $classFile->getClasses()
            );
        }, []);

        $expected = [
            TestAsset\Anonymous\WithAnonymousClass::class,
        ];

        $this->assertEquals($expected, $classNames);
    }

    /**
     * @requires PHP 7.1
     */
    public function testIgnoresMethodsNamedAfterKeywords()
    {
        $classFileLocator = new ClassFileLocator(__DIR__ . '/TestAsset/WithMethodsNamedAfterKeywords');

        $classFiles = \iterator_to_array($classFileLocator);

        $this->assertCount(2, $classFiles);

        $classNames = \array_reduce($classFiles, function (array $classNames, PhpClassFile $classFile) {
            return \array_merge(
                $classNames,
                $classFile->getClasses()
            );
        }, []);

        $expected = [
            TestAsset\WithMethodsNamedAfterKeywords\WithoutReturnTypeDeclaration::class,
            TestAsset\WithMethodsNamedAfterKeywords\WithReturnTypeDeclaration::class,
        ];

        sort($classNames);
        sort($expected);

        $this->assertEquals($expected, $classNames, '', 0.0, 10, true);
    }

    public function testIterationFindsClassInAFileWithUseFunction()
    {
        $locator = new ClassFileLocator(__DIR__);
        $found = false;

        foreach ($locator as $file) {
            if (preg_match('/ContainsUseFunction\.php$/', $file->getFilename())) {
                $found = true;
            }
        }
        $this->assertTrue($found, "Failed to find a file that contains `use function`");
    }
}
