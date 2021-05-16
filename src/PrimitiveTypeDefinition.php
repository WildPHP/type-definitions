<?php

/*
 * Copyright 2021 The WildPHP Team
 * See LICENSE.md in the project root.
 */

declare(strict_types=1);

namespace WildPHP\TypeDefinitions;

use WildPHP\TypeDefinitions\Exceptions\TypeDefinitionException;

/**
 * Class PrimitiveTypeDefinition
 *
 * @package WildPHP\TypeDefinitions
 */
class PrimitiveTypeDefinition implements TypeDefinitionInterface
{

    /**
     * Constant used for boolean types.
     * @see \gettype()
     */
    public const BOOLEAN = 'boolean';

    /**
     * Constant used for integer types.
     * @see \gettype()
     */
    public const INTEGER = 'integer';

    /**
     * Constant used for double or float types.
     * @see \gettype()
     */
    public const FLOAT = 'double';

    /**
     * Constant used for string types.
     * @see \gettype()
     */
    public const STRING = 'string';

    /**
     * Constant used for resource types.
     * @see \gettype()
     */
    public const RESOURCE = 'resource';

    /**
     * Constant used for closed resource types.
     * @see \gettype()
     */
    public const RESOURCE_CLOSED = 'resource (closed)';

    /**
     * Constant used for null types.
     * @see \gettype()
     */
    public const NULL = 'NULL';

    /**
     * Possible values for gettype()
     *
     * @var string[]
     * @see \gettype()
     */
    public const PRIMITIVE_TYPES = [
        self::BOOLEAN,
        self::INTEGER,
        self::FLOAT,
        self::STRING,
        self::RESOURCE,
        self::RESOURCE_CLOSED,
        self::NULL,
    ];

    /**
     * @var string
     */
    private $wantedType;

    /**
     * GetTypeTypeDefinition constructor.
     *
     * @param string $wantedType
     *
     * @throws \WildPHP\TypeDefinitions\Exceptions\TypeDefinitionException
     */
    public function __construct(string $wantedType)
    {
        if (!in_array($wantedType, self::PRIMITIVE_TYPES)) {
            throw new TypeDefinitionException(
                'Unknown gettype value passed to PrimitiveTypeDefinition'
            );
        }

        $this->wantedType = $wantedType;
    }

    /**
     * @inheritDoc
     */
    public function validate($value): bool
    {
        return gettype($value) === $this->wantedType;
    }

    /**
     * @inheritDoc
     */
    public function default()
    {
        switch ($this->wantedType) {
            case self::BOOLEAN:
                return false;

            case self::INTEGER:
                return 0;

            case self::FLOAT:
                return 0.0;

            case self::STRING:
                return '';

            default:
                return null;
        }
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function toDefinition(): string
    {
        return $this->wantedType;
    }
}
