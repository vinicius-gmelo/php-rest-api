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

    $route = new Route(array('method' => $method, 'path' => $path));

    $i = $this->search_route($route);

    if ($i === -1) {
      return false;
    } else {
      return true;
    }
  }

  public function create_route(string $method, string $path, ?callable $handler): bool
  {
    try {
      $route = new Route(array('method' => $method, 'path' => $path, 'handler' => $handler));
      array_push($this->routes, $route);
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }

  public function delete_route(string $method, string $path): bool
  {
    try {
      $i = $this->search_route(new Route(array('method' => $method, 'path' => $path)));
      array_splice($this->routes, $i, 1);
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }

  public function update_route(string $method, string $path, ?callable $handler): bool
  {

    $i = $this->search_route(new Route(array('method' => $method, 'path' => $path, 'handler' => $handler)));
    if ($i === -1) {
      return false;
    } else {
      try {
        $route = $this->routes[$i];
        $route->set_handler($handler);
        return true;
      } catch (\Exception $e) {
        return false;
      }
    }
  }

  public function resolve(array $request): void
  {

    $method = $request['REQUEST_METHOD'];
    $path = $request['PATH_INFO'] ?? '/';

    parse_str($request['QUERY_STRING'], $params);

    if ($this->route_exists($method, $path)) {
      $route = $this->routes[$this->search_route(new Route(array('method' => $method, 'path' => $path)))];
      # [TODO] Criar classe Apirouter para resolver a execução da handler
      $handler = $route->get_handler();
      if (isset($handler)) {
        if (func_num_args($handler) === 0) {
          $handler();
        } else {
          $handler($params['id'] ?? null);
        }
      }
    } else {
      http_response_code(404);
    }
  }
}
