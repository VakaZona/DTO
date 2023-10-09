<?php

namespace App\Tests\dto\Support;

use App\dto\Attributes\Required;
use App\dto\DTO;

class SimpleDataRequired extends DTO
{
    #[Required]
    public $foo;
}