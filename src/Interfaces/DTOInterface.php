<?php

namespace vakazona\Dto\Interfaces;

interface DTOInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data=[]);
}