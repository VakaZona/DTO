<?php

namespace vakazona\Dto\Tests\Support;

use vakazona\Dto\DTO;

class SimpleDataTypeUnion extends DTO
{
    public string|int $foo;
}