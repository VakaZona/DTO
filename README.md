# DTO

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
    'name' => Valery,
    'age' => 23,
])

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
## Tests
```
vendor/bin/phpunit
```