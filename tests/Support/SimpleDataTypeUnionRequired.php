<?php

namespace App\Tests\dto\Support;

use App\dto\Attributes\Required;
use App\dto\DTO;

class SimpleDataTypeUnionRequired extends DTO
{
    #[Required]
    public string|int $foo;
}