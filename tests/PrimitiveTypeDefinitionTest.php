<?php

/*
 * Copyright 2021 The WildPHP Team
 * See LICENSE.md in the project root.
 */

declare(strict_types=1);

namespace WildPHP\TypeDefinitions\Tests;

use PHPUnit\Framework\TestCase;
use WildPHP\TypeDefinitions\Exceptions\TypeDefinitionException;
use WildPHP\TypeDefinitions\PrimitiveTypeDefinition;

/**
 * Class PrimitiveTypeDefinitionTest
 *
 * @package WildPHP\TypeDefinitions\Tests
 * @covers  \WildPHP\TypeDefinitions\PrimitiveTypeDefinition
 */
class PrimitiveTypeDefinitionTest extends TestCase
{

    public function testValidate(): void
    {
        $stringTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::STRING);
        $intTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::INTEGER);
        $floatTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::FLOAT);
        $boolTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::BOOLEAN);
        $nullTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::NULL);

        $string = 'test';
        $int = 1;
        $float = 5.1;
        $bool = true;
        $null = null;

        self::assertTrue($stringTypeDefinition->validate($string));
        self::assertFalse($stringTypeDefinition->validate($int));
        self::assertFalse($stringTypeDefinition->validate($float));
        self::assertFalse($stringTypeDefinition->validate($bool));
        self::assertFalse($stringTypeDefinition->validate($null));

        self::assertFalse($intTypeDefinition->validate($string));
        self::assertTrue($intTypeDefinition->validate($int));
        self::assertFalse($intTypeDefinition->validate($float));
        self::assertFalse($intTypeDefinition->validate($bool));
        self::assertFalse($intTypeDefinition->validate($null));

        self::assertFalse($floatTypeDefinition->validate($string));
        self::assertFalse($floatTypeDefinition->validate($int));
        self::assertTrue($floatTypeDefinition->validate($float));
        self::assertFalse($floatTypeDefinition->validate($bool));
        self::assertFalse($floatTypeDefinition->validate($null));

        self::assertFalse($boolTypeDefinition->validate($string));
        self::assertFalse($boolTypeDefinition->validate($int));
        self::assertFalse($boolTypeDefinition->validate($float));
        self::assertTrue($boolTypeDefinition->validate($bool));
        self::assertFalse($boolTypeDefinition->validate($null));

        self::assertFalse($nullTypeDefinition->validate($string));
        self::assertFalse($nullTypeDefinition->validate($int));
        self::assertFalse($nullTypeDefinition->validate($float));
        self::assertFalse($nullTypeDefinition->validate($bool));
        self::assertTrue($nullTypeDefinition->validate($null));
    }

    public function testToDefinition(): void
    {
        $stringTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::STRING);
        $intTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::INTEGER);
        $floatTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::FLOAT);
        $boolTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::BOOLEAN);
        $nullTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::NULL);

        self::assertEquals(PrimitiveTypeDefinition::STRING, $stringTypeDefinition->toDefinition());
        self::assertEquals(PrimitiveTypeDefinition::INTEGER, $intTypeDefinition->toDefinition());
        self::assertEquals(PrimitiveTypeDefinition::FLOAT, $floatTypeDefinition->toDefinition());
        self::assertEquals(PrimitiveTypeDefinition::BOOLEAN, $boolTypeDefinition->toDefinition());
        self::assertEquals(PrimitiveTypeDefinition::NULL, $nullTypeDefinition->toDefinition());
    }

    public function testDefault(): void
    {
        $stringTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::STRING);
        $intTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::INTEGER);
        $floatTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::FLOAT);
        $boolTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::BOOLEAN);
        $nullTypeDefinition = new PrimitiveTypeDefinition(PrimitiveTypeDefinition::NULL);

        self::assertEquals('', $stringTypeDefinition->default());
        self::assertEquals(0, $intTypeDefinition->default());
        self::assertEquals(0.0, $floatTypeDefinition->default());
        self::assertEquals(false, $boolTypeDefinition->default());
        self::assertEquals(null, $nullTypeDefinition->default());
    }

    public function testConstructThrowsExceptionOnUnknownType(): void
    {
        $this->expectException(TypeDefinitionException::class);
        new PrimitiveTypeDefinition('alwaysAnInvalidType');
    }
}
