<?php

namespace vakazona\Dto\Tests;

use vakazona\Dto\DTO;
use vakazona\Dto\Exceptions\InvalidDataException;
use vakazona\Dto\Tests\Support\Classes\TestAbstractClass;
use vakazona\Dto\Tests\Support\Classes\TestClass;
use vakazona\Dto\Tests\Support\Classes\TestClassExtendsAbstractClass;
use vakazona\Dto\Tests\Support\Classes\TestClassImplementsInterface;
use vakazona\Dto\Tests\Support\Classes\TestClassImplementsInterfaceExtends;
use vakazona\Dto\Tests\Support\Classes\TestClassOther;
use vakazona\Dto\Tests\Support\Classes\TestInterface;

class ClassInheritanceTest extends BaseTestCase
{
    public function testClass()
    {
        $data = new class(['object' => new TestClass()]) extends DTO {
            public TestClass $object;
        };

        self::assertInstanceOf(TestClass::class, $data->object);
    }

    public function testClassFailing()
    {
        $this->expectException(InvalidDataException::class);

        $data = new class(['object' => new TestClassOther()]) extends DTO {
            public TestClass $object;
        };
    }

    public function testInterface()
    {
        $data = new class(['object' => new TestClassImplementsInterface()]) extends DTO {
            public TestInterface $object;
        };

        self::assertInstanceOf(TestClassImplementsInterface::class, $data->object);
    }

    public function testInterfaceExtendedByClass()
    {
        $data = new class(['object' => new TestClassImplementsInterfaceExtends()]) extends DTO {
            public TestInterface $object;
        };

        self::assertInstanceOf(TestClassImplementsInterfaceExtends::class, $data->object);
    }

    public function testInterfaceFailing()
    {
        $this->expectException(InvalidDataException::class);

        new class(['object' => new TestClass()]) extends DTO {
            public TestInterface $object;
        };
    }

    public function testAbstractClass()
    {
        $data = new class(['object' => new TestClassExtendsAbstractClass()]) extends DTO {
            public TestAbstractClass $object;
        };

        self::assertInstanceOf(TestClassExtendsAbstractClass::class, $data->object);
    }

}