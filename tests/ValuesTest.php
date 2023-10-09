<?php

namespace App\Tests\dto;

use App\dto\DTO;
use App\dto\Exceptions\InvalidDataException;
use App\Tests\dto\Support\SimpleData;
use App\Tests\dto\Support\SimpleDataNullable;
use App\Tests\dto\Support\SimpleDataNullableDefaultNull;
use App\Tests\dto\Support\SimpleDataNullableRequired;
use App\Tests\dto\Support\SimpleDataRequired;
use App\Tests\dto\Support\SimpleDataType;
use App\Tests\dto\Support\SimpleDataTypeRequired;
use App\Tests\dto\Support\SimpleDataTypeUnion;

class ValuesTest extends BaseTestCase
{
    public function testArrayValues()
    {
        $data = new class(['array' => []]) extends DTO {
            public array $array;
        };

        self::assertSame([], $data->array);
    }

    public function testBooleanValues()
    {
        $data = new class(['bool' => true]) extends DTO {
            public bool $bool;
        };

        self::assertSame(true, $data->bool);
    }

    public function testBooleanValuesMustBeStrict()
    {
        $this->expectException(InvalidDataException::class);

        new class(['bool' => 1]) extends DTO {
            public bool $bool;
        };
    }

    public function testIntValues()
    {
        $data = new class(['int' => 1]) extends DTO {
            public int $int;
        };

        self::assertSame(1, $data->int);
    }

    public function testIntValuesMustBeStrict()
    {
        $this->expectException(InvalidDataException::class);

        new class(['int' => '1']) extends DTO {
            public int $int;
        };
    }

    public function testFloatValues()
    {
        $data = new class(['float' => 1.0]) extends DTO {
            public float $float;
        };

        self::assertSame(1.0, $data->float);
    }

    public function testFloatValuesMustBeStrict()
    {
        $this->expectException(InvalidDataException::class);

        new class(['float' => '1.0']) extends DTO {
            public float $float;
        };
    }

    public function testClosureValues()
    {
        $data = new class(['callback' => fn () => null]) extends DTO {
            public \Closure $callback;
        };

        self::assertIsCallable($data->callback);
    }

    public function testObjectValues()
    {
        $object = new class() {
        };

        $data = new class(['object' => $object]) extends DTO {
            public object $object;
        };

        self::assertIsObject($data->object);
    }

    public function testValues()
    {
        $data = new SimpleData([]);

        self::assertTrue($data->isset('foo'));
        self::assertSame(null, $data->foo);

        $data = new SimpleData([
            'foo' => null,
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame(null, $data->foo);

        $data = new SimpleData([
            'foo' => 'bar',
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame('bar', $data->foo);
    }

    public function testValuesRequired()
    {
        $data = new SimpleDataRequired([
            'foo' => null,
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame(null, $data->foo);

        $data = new SimpleDataRequired([
            'foo' => 'bar',
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame('bar', $data->foo);
    }

    public function testValuesType()
    {
        $data = new SimpleDataType([]);

        self::assertFalse($data->isset('foo'));

        $data = new SimpleDataType([
            'foo' => 'bar',
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame('bar', $data->foo);
    }

    public function testValuesTypeRequired()
    {
        $data = new SimpleDataTypeRequired([
            'foo' => 'bar',
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame('bar', $data->foo);
    }

    public function testValuesTypeUnion()
    {
        $data = new SimpleDataTypeUnion([
            'foo' => 'bar',
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame('bar', $data->foo);

        $data = new SimpleDataTypeUnion([
            'foo' => 1,
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame(1, $data->foo);
    }

    public function testValuesNullable()
    {
        $data = new SimpleDataNullable([]);

        self::assertFalse($data->isset('foo'));

        $data = new SimpleDataNullable([
            'foo' => null,
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame(null, $data->foo);

        $data = new SimpleDataNullable([
            'foo' => 'bar',
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame('bar', $data->foo);
    }

    public function testValuesNullableRequired()
    {
        $data = new SimpleDataNullableRequired([
            'foo' => null,
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame(null, $data->foo);

        $data = new SimpleDataNullableRequired([
            'foo' => 'bar',
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame('bar', $data->foo);
    }

    public function testValuesNullableDefaultNull()
    {
        $data = new SimpleDataNullableDefaultNull([]);

        self::assertTrue($data->isset('foo'));
        self::assertSame(null, $data->foo);

        $data = new SimpleDataNullableDefaultNull([
            'foo' => null,
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame(null, $data->foo);

        $data = new SimpleDataNullableDefaultNull([
            'foo' => 'bar',
        ]);

        self::assertTrue($data->isset('foo'));
        self::assertSame('bar', $data->foo);
    }
}