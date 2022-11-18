<?php

namespace app;

use app\router\Router;
use app\lib\Api;

class App
{

  const DB = 'mysql';
  private Router $router;

  public function __construct()
  {
    $this->router = new Router();
    $this->set_router();
  }

  public function init($request)
  {
    $this->router->resolve($request);
    $dbh = null;
  }

  private function set_router()
  {

    $methods = ['post', 'get', 'put', 'delete'];
    $models = ['user', 'post'];

    foreach ($models as $model) {
      $path = '/api/' . $model . 's/';
      $api = new Api($model, self::DB);
      foreach ($methods as $method) {
        $this->router->create_route($method, $path, $api->$method);
      }
    }
  }
}
