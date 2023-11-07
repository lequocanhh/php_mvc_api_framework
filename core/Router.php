<?php

namespace app\core;

use app\controllers\SiteController;
use Psr\Container\ContainerInterface;

class Router
{
    public Request $request;
    public Response $response;
    private ContainerInterface $container;
    protected array $routes = [];

    public function __construct(Request $request, Response  $response,ContainerInterface $container)
    {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    public function get($path, $callback, $middleware = []): void
    {
        $this->routes['get'][$path] = $callback;
        $this->addRoute('get', $path, $callback, $middleware);
    }

    public function post($path, $callback, $middleware = []): void
    {
        $this->addRoute('post', $path, $callback, $middleware);
    }

    public function update($path, $callback, $middleware = []): void
    {
        $this->addRoute('update', $path, $callback, $middleware);
    }

    public function delete($path, $callback, $middleware = []): void
    {
        $this->addRoute('delete', $path, $callback, $middleware);
    }

    public function addRoute($method, $path, $callback, $middleware = []): void
    {
        $this->routes[$method][$path] = [
            'middleware' => $middleware,
            'callback' => $callback
        ];
    }

    public function matchRoute($path, $method)
    {
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeKey => $routeInfo) {
                $pattern = $this->convertToRegex($routeKey);
                if (preg_match($pattern, $path, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    return [$routeInfo['callback'], $params, $routeInfo['middleware']];
                }
            }
        }
        return false;
    }

    public function convertToRegex($route_key)
    {
        $regex = preg_replace_callback('/\{(\w+)\}/', function ($matches) {
            return "(?P<{$matches[1]}>[\w-]+)";
        }, $route_key);
        return "#^" . $regex . "$#";
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $routeInfo = $this->matchRoute($path, $method);

        if ($routeInfo === false) {
            $this->response->setStatusCode(404);
            return "Not found";
        }

        list($callback, $params, $middleware) = $routeInfo;

        if (!empty($middleware)) {
            foreach ($middleware as $middlewareCallback) {
                $this->container->call($middlewareCallback);
            }
        }

        return $this->container->call($callback, $params);
    }


}