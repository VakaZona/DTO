<?php

namespace App\Tests\dto\Support;

use App\dto\DTO;

class SimpleDataUnionNullable extends DTO
{
    public string|int|null $foo;
}