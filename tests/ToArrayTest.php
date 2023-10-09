<?php

namespace vakazona\Dto\Tests;

use vakazona\Dto\Attributes\Flexible;
use vakazona\Dto\DTO;

class ToArrayTest extends BaseTestCase
{
    public function testToArray()
    {
        $data = new class() extends DTO {
            public string $firstProperty = '1';
            public string $second_property = '2';
        };

        self::assertSame([
            'firstProperty' => '1',
            'second_property' => '2',
        ], $data->toArray());
    }

    public function testToArrayFlexible()
    {
        $data = new #[Flexible] class(['thirdProperty' => '3']) extends DTO {
            public string $firstProperty = '1';
            public string $second_property = '2';
        };

        self::assertSame([
            'firstProperty' => '1',
            'second_property' => '2',
            'thirdProperty' => '3',
        ], $data->toArray());
    }

    public function testToArrayNestedObjectsInArray()
    {
        $data = new class(['children' => [new class(['text' => 'foo']) extends DTO {
            public string $text;
        }]]) extends DTO {
            public array $children = [];
        };

        self::assertSame(['children' => [['text' => 'foo']]], $data->toArray());
    }

    public function testToArrayNestedObjectsInArrayDeep()
    {
        $data = new class(['children' => [new class(['children' => [new class(['text' => 'foo']) extends DTO {
            public string $text;
        }]]) extends DTO {
            public array $children = [];
        }]]) extends DTO {
            public array $children = [];
        };

        self::assertSame(['children' => [['children' => [['text' => 'foo']]]]], $data->toArray());
    }

    public function testFilteredStaticProperties()
    {
        $data = new class([]) extends DTO {
            protected static string $staticProperty = '1';
            public string $scopedProperty = '2';
        };

        self::assertSame([
            'scopedProperty' => '2',
        ], $data->toArray());
    }
}