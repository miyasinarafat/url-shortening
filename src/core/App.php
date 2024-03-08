<?php

namespace Core;

use RuntimeException;

class App
{
    /**
     * All registered keys.
     * @var array
     */
    protected static array $registry = [];

    /**
     * Bind a new key/value into the container.
     * @param string $key
     * @param mixed $value
     */
    public static function bind(string $key, mixed $value): void
    {
        static::$registry[$key] = $value;
    }

    /**
     * Retrieve a value from the registry.
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        if (! array_key_exists($key, static::$registry)) {
            throw new RuntimeException("No {$key} is bound in the container.");
        }

        return static::$registry[$key];
    }
}
