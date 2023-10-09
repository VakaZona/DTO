<?php

namespace vakazona\Dto\Tests\Support;

use vakazona\Dto\DTO;

class SimpleDataUnionNullable extends DTO
{
    public string|int|null $foo;
}