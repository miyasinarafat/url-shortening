<?php

namespace Core\Database;

use Redis;
use RedisException;

final class RedisConnection
{
    /**
     * @param array $config
     * @return Redis
     */
    public static function make(array $config): Redis
    {
        try {
            $redis = new Redis();
            $redis->connect($config['host'], $config['port']);

            return $redis;
        } catch (RedisException $e) {
            die('Redis:' . $e->getMessage());
        }
    }
}
