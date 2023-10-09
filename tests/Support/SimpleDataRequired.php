<?php

namespace vakazona\Dto\Tests\Support;

use vakazona\Dto\Attributes\Required;
use vakazona\Dto\DTO;

class SimpleDataRequired extends DTO
{
    #[Required]
    public $foo;
}