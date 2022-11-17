<?php

namespace app\router;

class Route
{

  private string $path;
  private string $method;
  private string $handler;

  public function __construct($method, $path, $handler = '')
  {

    $this->method = strtoupper($method);
    $this->path = $path;
    $this->handler = $handler;
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
