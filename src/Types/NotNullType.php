<?php

declare(strict_types=1);

namespace vakazona\Dto\Types;

class NotNullType implements Type
{
    public function isValid(mixed $value): bool
    {
        return null !== $value;
    }
}