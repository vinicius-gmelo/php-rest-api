<?php

namespace app\router;

class Route
{

  private string $method;
  private string $path;
  private ?callable $handler;

  public function __construct(array $route)
  {

    $this->method = strtoupper($route['method']);
    $this->path = $route['path'];
    $this->handler = $route['handler'] ?? null;
  }

  public function get_path()
  {
    return $this->path;
  }

  public function set_path($path)
  {
    $this->path = $path;
  }

  public function get_method()
  {
    return $this->method;
  }

  public function set_method($method)
  {
    $this->method = strtoupper($method);
  }

  public function get_handler()
  {
    return $this->handler;
  }

  public function set_handler($handler)
  {
    $this->handler = $handler;
  }
}
