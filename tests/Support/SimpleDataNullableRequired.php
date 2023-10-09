<?php

namespace vakazona\Dto\Tests\Support;

use vakazona\Dto\Attributes\Required;
use vakazona\Dto\DTO;

class SimpleDataNullableRequired extends DTO
{
    #[Required]
    public ?string $foo;
}