<?php

declare(strict_types=1);

namespace App\dto\Exceptions;

use App\dto\Property;

class InvalidDeclarationException extends \RuntimeException
{
    public static function fromProperty(Property $property): self
    {
        return new self("The property `{$property->getName()}` has been declared as nullable with default value but marked as required");
    }
}