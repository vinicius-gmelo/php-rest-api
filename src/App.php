<?php

namespace app;

use app\router\Router;
use app\lib\Api;

class App
{

  private Router $router;
  private Api $api;

  public function __construct()
  {
    $this->router = new Router();
    $this->api = new Api();
    $this->set_routes();
  }

  public function init($request)
  {
    $this->router->resolve($request);
    $dbh = null;
  }

  private function set_routes()
  {

    $methods = ['post', 'get', 'put', 'delete'];
    $paths = ['/api/users', '/api/posts'];

    foreach ($paths as $path) {
      foreach ($methods as $method) {
        $this->router->create_route($method, $path, $this->api->$method);
      }
    }
  }
}
