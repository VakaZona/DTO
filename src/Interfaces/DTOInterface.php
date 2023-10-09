<?php

namespace vakazona\Dto\Interfaces;

interface DTOInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = []);

    public function toArray():array;

    public function toJson():string;

    public function jsonSerialize(): array;

    public function getValues(): array;

    public function isSet(string $key):bool;
}