<?php

namespace app;

use app\router\Router;
use app\lib\RestApi;
use app\models\Post;
use app\models\User;
use app\config\database\Mysql;

class App
{

  const DB = 'Mysql';
  const MODELS = array('User', 'Post');
  private Router $router;

  public function __construct()
  {
    $this->router = new Router();
    $this->set_router();
  }

  public function init($request)
  {
    $this->router->resolve($request);
  }

  private function set_router()
  {

    $methods = array('post', 'get', 'put', 'delete');

    foreach (self::MODELS as $model) {
      $path = '/api/' . strtolower($model) . 's/';
      $db = self::DB;
      $api = new RestApi(new $model(), new $db());
      foreach ($methods as $method) {
        $this->router->create_route($method, $path, $api->$method);
      }
    }
  }
}
