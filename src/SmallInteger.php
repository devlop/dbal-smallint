<?php

declare(strict_types=1);

namespace Devlop\DBAL\Types;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class SmallInteger extends Type
{
    /**
     * The name of the custom type.
     *
     * @var string
     */
    public const NAME = 'smallinteger';

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform) : string
    {
        $name = $platform->getName();

        switch ($name) {
            case 'mysql':
            case 'mysql2':
                return $this->getMySqlPlatformSQLDeclaration($fieldDeclaration);
            default:
                throw new DBALException('Invalid platform: ' . $name);
        }
    }

    /**
     * Get the SQL declaration for MySQL.
     */
    protected function getMySqlPlatformSQLDeclaration(array $fieldDeclaration) : string
    {
        $declaration = 'SMALLINT';

        if ($fieldDeclaration['unsigned'] === true) {
            $declaration .= ' UNSIGNED';
        }

        if ($fieldDeclaration['notnull'] === false) {
            $declaration .= ' NULL';
        }

        if ($fieldDeclaration['autoincrement'] === true) {
            $declaration .= ' AUTO_INCREMENT';
        }

        return $declaration;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return self::NAME;
    }
}
