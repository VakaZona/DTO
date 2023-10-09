<?php
 namespace App\Tests\dto;

 use App\dto\Property;
 use PHPUnit\Framework\TestCase;

 abstract class BaseTestCase extends TestCase
 {
     protected static function assertValid(Property $property, $value)
     {
         self::assertTrue($property->isValid($value), ($error = $property->getError($value)) ? $error->getMessage() : '');
     }

     protected static function assertInvalid(Property $property, $value)
     {
         self::assertFalse($property->isValid($value));
     }
 }