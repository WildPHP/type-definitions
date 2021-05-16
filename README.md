# Type definition library
----------
[![Code analysis](https://github.com/WildPHP/type-definitions/actions/workflows/analysis.yml/badge.svg)](https://github.com/WildPHP/type-definitions/actions/workflows/analysis.yml)
[![Latest Stable Version](https://poser.pugx.org/wildphp/type-definitions/v/stable)](https://packagist.org/packages/wildphp/type-definitions)
[![Latest Unstable Version](https://poser.pugx.org/wildphp/type-definitions/v/unstable)](https://packagist.org/packages/wildphp/type-definitions)
[![Total Downloads](https://poser.pugx.org/wildphp/type-definitions/downloads)](https://packagist.org/packages/wildphp/type-definitions)

Library to provide type validation and expression. Includes an interpreter to transform short and concise syntax into usable types. 

## Installation
In order to use this library, install it through [Composer](https://getcomposer.org):

    $ composer require wildphp/type-definitions

## Type definitions using classes
Type definitions can be built using the classes in this library. There are 3 main classes:

- `PrimitiveTypeDefinition`
- `ClassTypeDefinition`
- `ArrayTypeDefinition`

### PrimitiveTypeDefinition
Primitive type definitions are those who refer to scalar or otherwise built-in types.
`PrimitiveTypeDefinition` acts as a wrapper around [gettype()](https://www.php.net/manual/en/function.gettype.php).

For example:

```php
$definition = new \WildPHP\TypeDefinitions\PrimitiveTypeDefinition('string');

echo $definition->validate('this is a valid string'); // true

echo $definition->validate(1); // false
echo $definition->validate(false); // false
```

Alternatively, types may be specified using one of the constants on the `PrimitiveTypeDefinition` class.
These map to the type specifiers for `gettype()` and are recommended to be used instead of specifying types manually.

```php
$definition = new \WildPHP\TypeDefinitions\PrimitiveTypeDefinition(\WildPHP\TypeDefinitions\PrimitiveTypeDefinition::STRING);
```

### ClassTypeDefinition
Class type definitions validate their value using [instanceof](https://www.php.net/manual/en/language.operators.type.php).
This means that any class will pass this definition if it is an instance of, or inheritor of, the given class.

`null` is also considered a valid value.

For example:

```php
$definition = new \WildPHP\TypeDefinitions\ClassTypeDefinition(stdClass::class);

$object = new stdClass();

echo $definition->validate($object); // true
echo $definition->validate(null); // true

echo $definition->validate('this is a string'); // false
echo $definition->validate(1); // false
echo $definition->validate(false); // false

```

### ArrayTypeDefinition
Array type definitions validate their values using a child type definition (a content definition).
This makes it possible to write complex nested structures.

Please note that ArrayTypeDefinition only validates values and not keys. Key validation would not make a lot of sense,
since PHP itself limits key types to strings and integers.

Validation will fail when *any* of the children does not conform to the content definition.

For example:

```php
$childDefinition = new \WildPHP\TypeDefinitions\PrimitiveTypeDefinition('string');
$definition = new \WildPHP\TypeDefinitions\ArrayTypeDefinition($childDefinition);

echo $definition->validate(['this is a valid string', 'another valid string']); // true

echo $definition->validate(1); // false
echo $definition->validate([1]); // false
echo $definition->validate(false); // false
echo $definition->validate([false]); // false
echo $definition->validate(['this is a string', 1]); // false, because 1 does not conform
```

## Type definitions using maps and strings
The library provides a `TypeDefinitionInterpreter` helper class to translate maps and strings into `TypeDefinitionInterface`
instances.

This is used [in the models library](https://github.com/wildphp/models) to provide swift model declaration and validation.

`createDefinitionMap` is used to translate the values of key-value based arrays into TypeDefinitionInterface implementations.
This method will preserve keys and will not modify the existing array.

For example:

```php
$map = [
    'array' => ['string'],
    'string' => 'string',
    'stdClass' => stdClass::class
];

$interpreted = \WildPHP\TypeDefinitions\TypeDefinitionInterpreter::createDefinitionMap($map);

// $interpreted['array'] is now an instance of ArrayTypeDefinition with a content definition of PrimitiveTypeDefinition with type 'string'
// $interpreted['string'] is now an instance of PrimitiveTypeDefinition with type 'string'
// $interpreted['stdClass'] is now an instance of ClassTypeDefinition with class identifier stdClass::class
```

If you do not need to interpret a map but would rather interpret a single value, use the `interpret` function:

```php
$definition = 'string';

$interpreted = \WildPHP\TypeDefinitions\TypeDefinitionInterpreter::interpret($definition);

// $interpreted is now an instance of PrimitiveTypeDefinition with type 'string'
```
