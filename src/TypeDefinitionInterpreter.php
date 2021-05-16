<?php

/*
 * Copyright 2021 The WildPHP Team
 * See LICENSE.md in the project root.
 */

declare(strict_types=1);

namespace WildPHP\TypeDefinitions;

/**
 * Class TypeDefinitionInterpreter
 *
 * @package WildPHP\TypeDefinitions
 */
class TypeDefinitionInterpreter
{

    /**
     * Generates a definition map from a given array of stringified definitions.
     *
     * @param array<string, string|string[]> $array
     *
     * @return array<string, \WildPHP\TypeDefinitions\TypeDefinitionInterface>
     * @throws \WildPHP\TypeDefinitions\Exceptions\TypeDefinitionException
     */
    public static function createDefinitionMap(array $array): array
    {
        return array_map(
            static function ($definition) {
                return self::interpret($definition);
            },
            $array
        );
    }

    /**
     * Interpret a given array.
     *
     * @param string|string[] $definition
     *
     * @throws \WildPHP\TypeDefinitions\Exceptions\TypeDefinitionException
     */
    public static function interpret($definition): TypeDefinitionInterface
    {
        if (is_array($definition)) {
            return new ArrayTypeDefinition(self::interpret($definition[0]));
        }

        if (class_exists($definition)) {
            return new ClassTypeDefinition($definition);
        }

        return new PrimitiveTypeDefinition($definition);
    }
}
