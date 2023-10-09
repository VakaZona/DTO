<?php

namespace vakazona\Dto\Tests\Support;

use vakazona\Dto\Attributes\Required;
use vakazona\Dto\DTO;

class SimpleDataNullableDefaultNullRequired extends DTO
{
    #[Required]
    public ?string $foo = null;
}