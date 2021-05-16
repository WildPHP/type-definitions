<?php

/*
 * Copyright 2021 The WildPHP Team
 * See LICENSE.md in the project root.
 */

declare(strict_types=1);

namespace WildPHP\TypeDefinitions\Tests;

use PHPUnit\Framework\TestCase;
use WildPHP\TypeDefinitions\ArrayTypeDefinition;
use WildPHP\TypeDefinitions\PrimitiveTypeDefinition;

/**
 * Class ArrayTypeDefinitionTest
 *
 * @package WildPHP\TypeDefinitions\Tests
 * @covers  \WildPHP\TypeDefinitions\ArrayTypeDefinition
 * @uses    \WildPHP\TypeDefinitions\PrimitiveTypeDefinition
 */
class ArrayTypeDefinitionTest extends TestCase
{

    public function testGetContentDefinition(): void
    {
        $primitiveDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::STRING);

        $arrayTypeDefinition = new ArrayTypeDefinition($primitiveDefinition);

        self::assertSame($primitiveDefinition, $arrayTypeDefinition->getContentDefinition());
    }

    public function testValidate(): void
    {
        $primitiveDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::STRING);

        $arrayTypeDefinition = new ArrayTypeDefinition($primitiveDefinition);

        $validArray = ['test', 'ing', 'this', 'definition'];
        $invalidArray = ['test', 1, 3, null, false];
        $invalidType = 1;

        self::assertTrue($arrayTypeDefinition->validate($validArray));
        self::assertFalse($arrayTypeDefinition->validate($invalidArray));
        self::assertFalse($arrayTypeDefinition->validate($invalidType));
    }

    public function testDefault(): void
    {
        $primitiveDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::STRING);

        $arrayTypeDefinition = new ArrayTypeDefinition($primitiveDefinition);

        self::assertEquals([], $arrayTypeDefinition->default());
    }

    public function testToDefinition(): void
    {
        $primitiveDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::STRING);

        $arrayTypeDefinition = new ArrayTypeDefinition($primitiveDefinition);

        self::assertEquals([$primitiveDefinition->toDefinition()], $arrayTypeDefinition->toDefinition());
    }
}
