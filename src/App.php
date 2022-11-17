<?php

namespace app;

use app\router\Router;
use app\models\User;
use app\database\MySqlDb;

class App
{

  private MySqlDb $db;
  private Router $router;
  private $routes = array(
    array('method' => 'post', 'path' => '/api/', 'handler' => 'create'),
    array('method' => 'get', 'path' => '/api/', 'handler' => 'retrieve'),
    array('method' => 'put', 'path' => '/api/', 'handler' => 'update'),
    array('method' => 'delete', 'path' => '/api/', 'handler' => 'delete')
  );

  public function __construct()
  {

    $this->db = new MySqlDb();

    $this->router = new Router();
    $this->set_router();
  }

  private function set_router()
  {
    foreach ($this->routes as $route) {
      $this->router->create_route($route['method'], $route['path'], $route['handler']);
    }
  }

  public function init($request)
  {
    $dbh = $this->db->connect();
    print $this->router->resolve($request);
  }
}
