<?php

namespace app\router;

use app\router\Route;
use app\router\RouterInterface;

class Router implements RouterInterface
{

  private array $routes;

  public function __construct()
  {
    $this->routes = array();
  }

  private function search_route(Route $route)
  {

    $method = $route->get_method();
    $path = $route->get_path();

    for ($i = 0; $i < count($this->routes); $i++) {
      $route = $this->routes[$i];
      if ($route->get_method() === $method && $route->get_path() === $path) {
        return $i;
      }
    }

    return -1;
  }

  public function route_exists(string $method, string $path): bool
  {

    $route = new Route($method, $path);

    $i = $this->search_route($route);

    if ($i === -1) {
      return false;
    } else {
      return true;
    }
  }

  public function create_route(string $method, string $path, string $handler): bool
  {
    try {
      $route = new Route($method, $path, $handler);
      array_push($this->routes, $route);
      return true;
    } catch (\Exception $e) {
      print $e->getMessage();
      return false;
    }
  }

  public function delete_route(string $method, string $path): bool
  {
    try {
      $i = $this->search_route(new Route($method, $path));
      array_splice($this->routes, $i, 1);
      return true;
    } catch (\Exception $e) {
      print $e->getMessage();
      return false;
    }
  }

  public function update_route(string $method, string $path, string $handler): bool
  {

    $i = $this->search_route(new Route($method, $path));
    if ($i === -1) {
      return false;
    } else {
      try {
        $route = $this->routes[$i];
        $route->set_handler($handler);
        return true;
      } catch (\Exception $e) {
        print $e->getMessage();
        return false;
      }
    }
  }

  public function get_routes(): array
  {
    return $this->routes;
  }

  public function resolve(array $request): string
  {

    $method = $request['REQUEST_METHOD'];
    $path = $request['REQUEST_URI'];

    if ($this->route_exists($method, $path)) {
      return json_encode(array('message' => 'success', 'code' => 200));
    } else {
      return json_encode(array('message' => 'not found', 'code' => 404));
    }
  }
}
