<?php

namespace App\Tests\dto\Support;

use App\dto\Attributes\Required;
use App\dto\DTO;

class SimpleDataUnionNullableRequired extends DTO
{
    #[Required]
    public string|int|null $foo;
}