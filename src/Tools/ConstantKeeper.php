<?php

declare(strict_types=1);

namespace App\Tools;

abstract class ConstantKeeper
{
    public static function getConstants()
    {
        $reflection = new \ReflectionClass(static::class);

        return $reflection->getConstants();
    }

    public static function getConstantNames()
    {
        return array_keys(self::getConstants());
    }

    public static function getConstantValues()
    {
        return array_values(self::getConstants());
    }

    public static function getNameByValue($value): ?string
    {
        $constants = array_flip(static::getConstants());

        return $constants[$value] ?? null;
    }
}