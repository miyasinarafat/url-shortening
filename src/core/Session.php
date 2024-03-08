<?php

namespace Core;

final class Session
{
    /**
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return (bool) static::get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * @return void
     */
    public static function unflash(): void
    {
        unset($_SESSION['_flash']);
    }

    /**
     * @return void
     */
    public static function flush(): void
    {
        $_SESSION = [];
    }

    /**
     * @return void
     */
    public static function destroy(): void
    {
        static::flush();

        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
