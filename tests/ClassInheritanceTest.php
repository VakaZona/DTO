<?php

namespace App\Tests\dto;

use App\dto\DTO;
use App\dto\Exceptions\InvalidDataException;
use App\Tests\dto\Support\Classes\TestAbstractClass;
use App\Tests\dto\Support\Classes\TestClass;
use App\Tests\dto\Support\Classes\TestClassExtendsAbstractClass;
use App\Tests\dto\Support\Classes\TestClassImplementsInterface;
use App\Tests\dto\Support\Classes\TestClassImplementsInterfaceExtends;
use App\Tests\dto\Support\Classes\TestClassOther;
use App\Tests\dto\Support\Classes\TestInterface;
use PHPUnit\Framework\TestCase;

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