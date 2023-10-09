<?php

namespace App\Tests\dto\Support;

use App\dto\DTO;

class SimpleDataNullableDefaultNull extends DTO
{
    public ?string $foo = null;
}