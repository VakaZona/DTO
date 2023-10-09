<?php

namespace App\Tests\dto\Support;

use App\dto\DTO;

class SimpleDataNullable extends DTO
{
    public ?string $foo;
}