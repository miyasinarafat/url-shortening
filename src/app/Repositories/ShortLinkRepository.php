<?php

namespace App\Repositories;

use App\Models\ShortLink;
use Core\Cache;
use RedisException;

final class ShortLinkRepository
{
    /**
     * @return array|null
     */
    public function getList(): ?array
    {
        if (! $links = ShortLink::get()) {
            return null;
        }

        return $links;
    }

    /**
     * @param string $target
     * @return int
     */
    public function save(string $target): int
    {
        return ShortLink::insert(['target_url' => $target]);
    }

    /**
     * @param int $id
     * @return array|null
     * @throws RedisException
     */
    public function findById(int $id): ?array
    {
        $cacheKey = Cache::generateCacheKey(__METHOD__, (string)$id);

        if (! $result = Cache::get($cacheKey)) {
            $result = ShortLink::findById($id);

            if (! $result) {
                return null;
            }

            Cache::set($cacheKey, $result, 3);
        }

        return $result;
    }
}
