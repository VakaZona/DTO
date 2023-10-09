<?php

namespace App\Tests\dto\Support;

use App\dto\Attributes\Required;
use App\dto\DTO;

class SimpleDataNullableRequired extends DTO
{
    #[Required]
    public ?string $foo;
}