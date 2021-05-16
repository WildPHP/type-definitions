<?php

/*
 * Copyright 2021 The WildPHP Team
 * See LICENSE.md in the project root.
 */

declare(strict_types=1);

namespace WildPHP\TypeDefinitions\Tests;

use stdClass;
use WildPHP\TypeDefinitions\ClassTypeDefinition;
use PHPUnit\Framework\TestCase;
use WildPHP\TypeDefinitions\Exceptions\TypeDefinitionException;

/**
 * Class ClassTypeDefinitionTest
 *
 * @package WildPHP\TypeDefinitions\Tests
 * @covers \WildPHP\TypeDefinitions\ClassTypeDefinition
 */
class ClassTypeDefinitionTest extends TestCase
{

    public function testToDefinition(): void
    {
        $classDefinition = new ClassTypeDefinition(stdClass::class);

        self::assertEquals(stdClass::class, $classDefinition->toDefinition());
    }

    public function testConstructThrowsExceptionWhenClassDoesNotExist(): void
    {
        $this->expectException(TypeDefinitionException::class);
        new ClassTypeDefinition('testClassWhichWillNeverExist');
    }

    public function testValidate(): void
    {
        $classDefinition = new ClassTypeDefinition(stdClass::class);

        $stdClass = new stdClass();
        $invalidType = 1;

        self::assertTrue($classDefinition->validate(null));
        self::assertTrue($classDefinition->validate($stdClass));
        self::assertFalse($classDefinition->validate($invalidType));
    }

    public function testDefault(): void
    {
        $classDefinition = new ClassTypeDefinition(stdClass::class);

        self::assertNull($classDefinition->default());
    }
}
