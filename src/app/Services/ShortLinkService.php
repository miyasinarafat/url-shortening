<?php

namespace App\Services;

use Tuupola\Base62;

final class ShortLinkService
{
    private static ?Base62 $encoder = null;

    /**
     * Generate instance of base62 class
     * @return Base62
     */
    private static function make(): Base62
    {
        if (! self::$encoder) {
            self::$encoder = new Base62();
        }

        return self::$encoder;
    }

    /**
     * Encode short link entity id
     * @param int $id
     * @return string
     */
    public static function encode(int $id): string
    {
        return self::make()->encodeInteger($id);
    }

    /**
     * Decode short link entity id from hash
     * @param string $hash
     * @return int
     */
    public static function decode(string $hash): int
    {
        return self::make()->decodeInteger($hash);
    }
}
