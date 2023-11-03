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

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $routeInfo = $this->routes[$method][$path] ?? false;

        if($routeInfo === false){
            $this->response->setStatusCode(404);
            return "Not found";
        }

        $middleware = $routeInfo['middleware'];
        if(!empty($middleware)){
            $this->container->call($middleware);
        }

        $callback = $routeInfo['callback'];
        return $this->container->call($callback);
    }


}