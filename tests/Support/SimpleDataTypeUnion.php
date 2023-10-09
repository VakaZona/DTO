<?php

namespace App\Tests\dto\Support;

use App\dto\DTO;

class SimpleDataTypeUnion extends DTO
{
    public string|int $foo;
}