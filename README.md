# DTO

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Custom DTO](#custom-dto)
- [Tests](#tests)

## Installation

```
composer require vakazona/dto
```

## Usage

```php
use vakazona\Dto\DTO;

class TestDTO extends DTO
{
    public string $name;
    
    public ?string $lastName;
    
    public string|int $age;
    
    public bool $developer = true;
}

$data = new TestDTO([
    'name' => 'Valery',
    'age' => 23,
]);

$data->name; // Valery
$data->age; // 23
$data->developer; // true
```

### Require

```php
use vakazona\Dto\DTO;
use vakazona\Dto\Attributes\Required;

class TestDTO extends DTO
{
    #[Required]
    public string $price;
}

$data = new TestDTO([]);
```

> Exceptions\InvalidDataException: The required property \`price\` is missing

### Flexible

```php
use vakazona\Dto\DTO;
use vakazona\Dto\Attributes\Flexible;

#[Flexible]
class TestDTO extends DTO
{
    public string $name;
}

$data = new TesDTO([
    'name' => 'Valery',
    'age' => 23,
]);

$data->toArray(); // ['name' => 'Valery', 'age' => '23'];
```

## Custom DTO
### Custom property
```php
use vakazona\Dto\DTO;

class CustomPropertyDTO extends DTO
{
    public string $name;

    public int $age;

}
```
### Main property
```php
use vakazona\Dto\DTO;

class TestCustomDTO extends DTO
{
    public CustomPropertyDTO $customProperty;
}

```
### Usage
```php
$data = new TestCustomDTO([
            'customProperty' => new CustomPropertyDTO([
                'name' => 'Valera',
                'age' => 23
            ])
        ]);

```

## Tests
```
vendor/bin/phpunit
```
or
```
composer test
```