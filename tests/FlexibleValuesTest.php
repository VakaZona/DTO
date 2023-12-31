<?php

namespace  vakazona\Dto\Tests;

use vakazona\Dto\Attributes\Flexible;
use vakazona\Dto\DTO;
use vakazona\Dto\Exceptions\InvalidDataException;
use vakazona\Dto\Tests\Support\FlexibleData;

class FlexibleValuesTest extends BaseTestCase
{
    public function testClassIsDetectedAsFlexible()
    {
        self::assertTrue(
            FlexibleData::isFlexible()
        );
    }

    public function testNotFlexibleFailing()
    {
        $this->expectException(InvalidDataException::class);

        new class(['foo' => 'bar']) extends DTO {
        };
    }

    public function testNotFlexibleFailingMultiple()
    {
        $this->expectException(InvalidDataException::class);

        new class(['foo' => 'bar', 'bar' => 'foo']) extends DTO {
        };
    }

    public function testOverloading()
    {
        $data = new #[Flexible] class(['foo' => 'bar']) extends DTO {
        };

        self::assertSame('bar', $data->foo);
    }

    public function testOverloadingWithExisting()
    {
        $data = new #[Flexible] class(['foo' => 'bar', 'bar' => 'foo']) extends DTO {
            public string $bar;
        };

        self::assertSame('bar', $data->foo);
        self::assertSame('foo', $data->bar);
    }
}