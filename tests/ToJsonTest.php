<?php

namespace App\Tests\dto;

use App\dto\DTO;
use PHPUnit\Framework\TestCase;

class ToJsonTest extends BaseTestCase
{
    public function testToJson()
    {
        $data = new class(['foo' => 'bar']) extends DTO {
            public string $foo;
        };

        self::assertEquals('{"foo":"bar"}', $data->toJson());
    }

    public function testToJsonObject()
    {
        $data = new class(['foo' => (object) ['foo' => 'bar']]) extends DTO {
            public \stdClass $foo;
        };

        self::assertEquals('{"foo":{"foo":"bar"}}', $data->toJson());
    }
}