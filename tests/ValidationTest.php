<?php

namespace App\Tests\dto;

use App\dto\Attributes\Required;
use App\dto\DTO;
use App\dto\Exceptions\InvalidDataException;
use App\dto\Exceptions\InvalidDeclarationException;
use App\dto\Property;
use App\dto\Values\MissingValue;
use App\Tests\dto\Support\SimpleData;
use App\Tests\dto\Support\SimpleDataNullable;
use App\Tests\dto\Support\SimpleDataNullableDefaultNull;
use App\Tests\dto\Support\SimpleDataNullableDefaultNullRequired;
use App\Tests\dto\Support\SimpleDataNullableRequired;
use App\Tests\dto\Support\SimpleDataRequired;
use App\Tests\dto\Support\SimpleDataType;
use App\Tests\dto\Support\SimpleDataTypeRequired;
use App\Tests\dto\Support\SimpleDataTypeUnion;
use App\Tests\dto\Support\SimpleDataTypeUnionRequired;
use App\Tests\dto\Support\SimpleDataUnionNullable;
use App\Tests\dto\Support\SimpleDataUnionNullableRequired;


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