<?php

namespace Core;

use Redis;
use RedisException;

class Cache
{
    /**
     * @param string ...$args
     * @return string|null
     */
    public static function generateCacheKey(string ...$args): ?string
    {
        if (count($args) === 0) {
            return null;
        }

        return md5(implode('|', $args));
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $hours
     * @return bool
     * @throws RedisException
     */
    public static function set(string $key, mixed $value, int $hours = 0): bool
    {
        /** @var Redis $redis */
        $redis = App::get('redis');

        if ($hours > 0) {
            return $redis->setex($key, $hours * 60 * 60, serialize($value));
        }

        return $redis->set($key, serialize($value));
    }

    /**
     * @param string $key
     * @return mixed
     * @throws RedisException
     */
    public static function get(string $key): mixed
    {
        /** @var Redis $redis */
        $redis = App::get('redis');

        $value = $redis->get($key);

        return $value !== false
            ? unserialize($value, ['allowed_classes' => false])
            : null;
    }

    /**
     * @param string $key
     * @return bool
     * @throws RedisException
     */
    public static function flush(string $key): bool
    {
        /** @var Redis $redis */
        $redis = App::get('redis');

        return $redis->del($key) > 0;
    }
}
