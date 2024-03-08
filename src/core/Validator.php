<?php

namespace Core;

final class Validator
{
    /**
     * @param string $url
     * @return bool
     */
    public static function url(string $url): bool
    {
        return ! filter_var($url, FILTER_VALIDATE_URL);
    }
}
