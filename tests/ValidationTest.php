<?php

namespace vakazona\Dto\Tests;

use vakazona\Dto\Attributes\Required;
use vakazona\Dto\DTO;
use vakazona\Dto\Exceptions\InvalidDataException;
use vakazona\Dto\Exceptions\InvalidDeclarationException;
use vakazona\Dto\Property;
use vakazona\Dto\Values\MissingValue;
use vakazona\Dto\Tests\Support\SimpleData;
use vakazona\Dto\Tests\Support\SimpleDataNullable;
use vakazona\Dto\Tests\Support\SimpleDataNullableDefaultNull;
use vakazona\Dto\Tests\Support\SimpleDataNullableDefaultNullRequired;
use vakazona\Dto\Tests\Support\SimpleDataNullableRequired;
use vakazona\Dto\Tests\Support\SimpleDataRequired;
use vakazona\Dto\Tests\Support\SimpleDataType;
use vakazona\Dto\Tests\Support\SimpleDataTypeRequired;
use vakazona\Dto\Tests\Support\SimpleDataTypeUnion;
use vakazona\Dto\Tests\Support\SimpleDataTypeUnionRequired;
use vakazona\Dto\Tests\Support\SimpleDataUnionNullable;
use vakazona\Dto\Tests\Support\SimpleDataUnionNullableRequired;


class ValidationTest extends BaseTestCase
{
    public function testValidation()
    {
        $property = Property::collectFromClass(SimpleData::class)['foo'];

        self::assertValid($property, '');
        self::assertValid($property, 1);
        self::assertValid($property, null);
        self::assertValid($property, new MissingValue());
    }

    public function testValidationRequired()
    {
        $property = Property::collectFromClass(SimpleDataRequired::class)['foo'];

        self::assertValid($property, '');
        self::assertValid($property, 1);
        self::assertValid($property, null);
        self::assertInvalid($property, new MissingValue());
    }

    public function testValidationType()
    {
        $property = Property::collectFromClass(SimpleDataType::class)['foo'];

        self::assertValid($property, '');
        self::assertInvalid($property, 1);
        self::assertInvalid($property, null);
        self::assertValid($property, new MissingValue());
    }

    public function testValidationTypeRequired()
    {
        $property = Property::collectFromClass(SimpleDataTypeRequired::class)['foo'];

        self::assertValid($property, '');
        self::assertInvalid($property, 1);
        self::assertInvalid($property, null);
        self::assertInvalid($property, new MissingValue());
    }

    public function testValidationTypeUnion()
    {
        $property = Property::collectFromClass(SimpleDataTypeUnion::class)['foo'];

        self::assertValid($property, 'bar');
        self::assertValid($property, 1);
        self::assertInvalid($property, null);
        self::assertValid($property, new MissingValue());
    }

    public function testValidationTypeUnionNullable()
    {
        $property = Property::collectFromClass(SimpleDataUnionNullable::class)['foo'];

        self::assertValid($property, 'bar');
        self::assertValid($property, 1);
        self::assertValid($property, null);
        self::assertValid($property, new MissingValue());
    }

    public function testValidationTypeUnionNullableRequired()
    {
        $property = Property::collectFromClass(SimpleDataUnionNullableRequired::class)['foo'];

        self::assertValid($property, 'bar');
        self::assertValid($property, 1);
        self::assertValid($property, null);
        self::assertInvalid($property, new MissingValue());
    }

    public function testValidationTypeUnionRequired()
    {
        $property = Property::collectFromClass(SimpleDataTypeUnionRequired::class)['foo'];

        self::assertValid($property, 'bar');
        self::assertValid($property, 1);
        self::assertInvalid($property, null);
        self::assertInvalid($property, new MissingValue());
    }

    public function testValidationNullable()
    {
        $property = Property::collectFromClass(SimpleDataNullable::class)['foo'];

        self::assertValid($property, '');
        self::assertInvalid($property, 1);
        self::assertValid($property, null);
        self::assertValid($property, new MissingValue());
    }

    public function testValidationNullableRequired()
    {
        $property = Property::collectFromClass(SimpleDataNullableRequired::class)['foo'];

        self::assertValid($property, '');
        self::assertInvalid($property, 1);
        self::assertValid($property, null);
        self::assertInvalid($property, new MissingValue());
    }

    public function testValidationNullableDefaultNull()
    {
        $property = Property::collectFromClass(SimpleDataNullableDefaultNull::class)['foo'];

        self::assertValid($property, '');
        self::assertInvalid($property, 1);
        self::assertValid($property, null);
        self::assertValid($property, new MissingValue());
    }

    public function testValidationNullableDefaultNullRequired()
    {
        $this->expectException(InvalidDeclarationException::class);

        Property::collectFromInstance(new SimpleDataNullableDefaultNullRequired())['foo'];
    }

    public function testExceptionPropertiesSet()
    {
        try {
            new class(['int' => null]) extends DTO {
                #[Required]
                public int $int;
            };

            self::fail();
        } catch (InvalidDataException $exception) {
            self::assertCount(1, $exception->getProperties());
            self::assertSame('int', $exception->getProperties()[0]->getName());
        }

        try {
            new class(['int' => '1']) extends DTO {
                public int $int;
            };

            self::fail();
        } catch (InvalidDataException $exception) {
            self::assertCount(1, $exception->getProperties());
            self::assertSame('int', $exception->getProperties()[0]->getName());
        }

        try {
            new class([]) extends DTO {
                #[Required]
                public int $foo;

                #[Required]
                public int $bar;
            };

            self::fail();
        } catch (InvalidDataException $exception) {
            self::assertCount(2, $exception->getProperties());
        }
    }
}