<?php

use App\Services\ShortLinkService;
use Core\Session;

/**
 * Require a view
 * @param string $name
 * @param array $data
 * @return mixed
 */
function view(string $name, array $data = []): mixed
{
    extract($data);

    return require BASE_PATH ."src/views/{$name}.view.php";
}

/**
 * Redirect to a new page
 * @param string $path
 */
function redirect(string $path)
{
    header("Location: {$path}");
}

/**
 * Dump and die
 * @param mixed $data
 */
function dd(mixed $data): void
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    die();
}

/**
 * Encode short link entity id
 * @param int $id
 * @return string
 */
function encode(int $id): string
{
    return ShortLinkService::encode($id);
}

/**
 * Decode short link entity id from hash
 * @param string $hash
 * @return int
 */
function decode(string $hash): int
{
    return ShortLinkService::decode($hash);
}

/**
 * Get client IP address
 * @return string
 */
function getIPAddress(): string
{
    /** To get shared ISP IP address */
    if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    /**
     * Check for IPs passing through proxy servers
     * Check if multiple IP addresses are set and take the first one
     */
    if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipAddressList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipAddressList as $ip) {
            if (! empty($ip)) {
                return $ip;
            }
        }
    }

    if (! empty($_SERVER['HTTP_X_FORWARDED'])) {
        return $_SERVER['HTTP_X_FORWARDED'];
    }

    if (! empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    }

    if (! empty($_SERVER['HTTP_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_FORWARDED_FOR'];
    }

    if (! empty($_SERVER['HTTP_FORWARDED'])) {
        return $_SERVER['HTTP_FORWARDED'];
    }

    return $_SERVER['REMOTE_ADDR'];
}

/**
 * Check if session has value by the key
 * @param string $key
 * @return bool
 */
function sessionHas(string $key): bool
{
    return Session::has($key);
}

/**
 * Get session value by key
 * @param string $key
 * @return mixed
 */
function sessionGet(string $key): mixed
{
    return Session::get($key);
}
