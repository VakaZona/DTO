<?php

namespace vakazona\Dto\Tests\Support;

use vakazona\Dto\DTO;

class SimpleDataNullableDefaultNull extends DTO
{
    public ?string $foo = null;
}