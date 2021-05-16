<?php

/*
 * Copyright 2021 The WildPHP Team
 * See LICENSE.md in the project root.
 */

declare(strict_types=1);

namespace WildPHP\TypeDefinitions\Tests;

use PHPUnit\Framework\TestCase;
use stdClass;
use WildPHP\TypeDefinitions\ArrayTypeDefinition;
use WildPHP\TypeDefinitions\ClassTypeDefinition;
use WildPHP\TypeDefinitions\PrimitiveTypeDefinition;
use WildPHP\TypeDefinitions\TypeDefinitionInterpreter;

/**
 * Class TypeDefinitionInterpreterTest
 *
 * @package WildPHP\TypeDefinitions\Tests
 * @covers  \WildPHP\TypeDefinitions\TypeDefinitionInterpreter
 * @uses    \WildPHP\TypeDefinitions\ArrayTypeDefinition
 * @uses    \WildPHP\TypeDefinitions\ClassTypeDefinition
 * @uses    \WildPHP\TypeDefinitions\PrimitiveTypeDefinition
 */
class TypeDefinitionInterpreterTest extends TestCase
{

    public function testInterpret(): void
    {
        $map = [
            'array' => [PrimitiveTypeDefinition::STRING],
            'string' => PrimitiveTypeDefinition::STRING,
            'stdClass' => stdClass::class
        ];

        $interpretedArray = TypeDefinitionInterpreter::interpret($map['array']);
        $interpretedString = TypeDefinitionInterpreter::interpret($map['string']);
        $interpretedClass = TypeDefinitionInterpreter::interpret($map['stdClass']);

        self::assertInstanceOf(ArrayTypeDefinition::class, $interpretedArray);
        self::assertInstanceOf(PrimitiveTypeDefinition::class, $interpretedString);
        self::assertInstanceOf(ClassTypeDefinition::class, $interpretedClass);
    }

    public function testCreateDefinitionMap(): void
    {
        $map = [
            'array' => [PrimitiveTypeDefinition::STRING],
            'string' => PrimitiveTypeDefinition::STRING,
            'stdClass' => stdClass::class
        ];

        $interpreted = TypeDefinitionInterpreter::createDefinitionMap($map);

        self::assertInstanceOf(ArrayTypeDefinition::class, $interpreted['array']);
        self::assertInstanceOf(PrimitiveTypeDefinition::class, $interpreted['string']);
        self::assertInstanceOf(ClassTypeDefinition::class, $interpreted['stdClass']);
    }
}
