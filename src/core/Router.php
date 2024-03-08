<?php

namespace Core;

use RuntimeException;

final class Router
{
    /**
     * All registered routes.
     * @var array
     */
    public array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * Load a user's routes file.
     * @param string $file
     * @return Router
     */
    public static function load(string $file): static
    {
        $router = new static();

        require $file;

        return $router;
    }

    /**
     * Register a GET route.
     * @param string $uri
     * @param string $controller
     */
    public function get(string $uri, string $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Register a POST route.
     * @param string $uri
     * @param string $controller
     */
    public function post(string $uri, string $controller): void
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Load the requested URI's associated controller method.
     * @param string $uri
     * @param string $requestType
     * @return mixed
     * @throws RuntimeException
     */
    public function direct(string $uri, string $requestType): mixed
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        $parameterHandler = null;
        foreach ($this->routes[$requestType] as $route => $handler) {
            $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $route);
            $uri = str_starts_with($uri, '/') ? $uri : '/' . $uri;

            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                array_shift($matches);
                $parameterHandler = $handler;
                break;
            }
        }

        if ($parameterHandler) {
            $router = explode('@', $parameterHandler);
            return $this->callAction(
                $router[0],
                $router[1],
                $matches
            );
        }

        throw new RuntimeException('No route defined for this URI.');
    }

    /**
     * Load and call the relevant controller action.
     * @param string $controller
     * @param string $action
     * @param array $parameters
     * @return mixed
     */
    protected function callAction(string $controller, string $action, array $parameters = []): mixed
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller();

        if (! method_exists($controller, $action)) {
            throw new RuntimeException(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return call_user_func_array([$controller, $action], $parameters);
    }
}
