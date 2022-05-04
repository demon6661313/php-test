<?php

namespace App\Router;

use App\Controllers\Controller;

class Router
{
    const GET = 'GET';
    const DELETE = 'DELETE';
    protected $routes = [];

    public function get(string $uri, array|callable $action)
    {
        $this->addRoute(self::GET, $uri, $action);
    }

    public function delete(string $uri, array|callable $action)
    {
        $this->addRoute(self::DELETE, $uri, $action);
    }

    protected function addRoute(string $method, string $uri, array|callable $action)
    {
        $this->routes[$method][$uri] = $action;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
