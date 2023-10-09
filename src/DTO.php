<?php

declare(strict_types=1);

namespace App\dto;

use App\dto\Attributes\Flexible;
use App\dto\Exceptions\InvalidDataException;
use App\dto\Exceptions\InvalidDeclarationException;
use App\dto\Interfaces\DTOInterface;
use App\dto\Values\MissingValue;

abstract class DTO implements DTOInterface, \JsonSerializable
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        $properties = Property::collectFromInstance($this);

        $errors = [];

        foreach ($properties as $property) {
            if ( ! $property->isCorrectlyDeclared()) {
                throw InvalidDeclarationException::fromProperty($property);
            }

            $value = $property->extractValueFromData($data);

            if ( ! $property->isValid($value)) {
                $errors[] = $property->getError($value);

                continue;
            }

            if ($value instanceof MissingValue) {
                continue;
            }

            $this->{$property->getName()} = $value;
        }

        if ( ! empty($errors)) {
            throw InvalidDataException::any($errors);
        }

        $diff = array_diff_key($data, $properties);

        if (false === static::isFlexible() && count($diff) > 0) {
            throw InvalidDataException::notFlexible(array_keys($diff));
        }

        foreach ($diff as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Create an instance from given data array.
     *
     * @param array<string, mixed> $data
     *
     * @return static
     */
    public static function fromArray(array $data = []): static
    {
        return new static($data);
    }

    /**
     * Determine if the dto is flexible and will accept more properties than declared.
     *
     * @return bool
     */
    public static function isFlexible(): bool
    {
        return ! empty(
        (new \ReflectionClass(static::class))->getAttributes(Flexible::class)
        );
    }

    /**
     * Get the property instance for a given key.
     *
     * @param string $key
     *
     * @return \App\dto\Property
     */
    private function getProperty(string $key): Property
    {
        return Property::fromKey($key, $this);
    }

    /**
     * Determine if a property has been initialized with a value.
     *
     * @param string $key
     *
     * @return bool
     */
    public function isset(string $key): bool
    {
        return array_key_exists($this->getProperty($key)->getName(), get_object_vars($this));
    }

    /**
     * Get public values.
     *
     * @return array<string, mixed>
     */
    public function getValues(): array
    {
        return get_object_vars($this);
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Get a string of json formatted values.
     *
     * @throws \JsonException
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }

    /**
     * Get an array of properties (includes flexible).
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->walkValuesDataCallback(fn (self $value) => $value->toArray());
    }

    /**
     * Iterate over instance values with a given callback applied to DTO instances.
     *
     * @param \Closure $callback
     *
     * @return array<string, mixed>
     */
    private function walkValuesDataCallback(\Closure $callback): array
    {
        $serializeItem = static function ($value, \Closure $callback) {
            if ($value instanceof self) {
                return $callback($value);
            }

            if ($value instanceof \JsonSerializable) {
                return $value->jsonSerialize();
            }

            return $value;
        };

        return array_map(static function ($value) use ($callback, $serializeItem) {
            if (is_array($value)) {
                foreach ($value as $key => $item) {
                    $value[$key] = $serializeItem($item, $callback);
                }
            }

            return $serializeItem($value, $callback);
        }, $this->getValues());
    }
}