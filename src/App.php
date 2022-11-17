<?php

namespace app;

use app\router\Router;
use app\config\database\Database;
use app\config\database\MySqlDb;

class App
{

  private Database $db;
  private Router $router;
  private $routes = array(
    array('method' => 'post', 'path' => '/api/', 'handler' => 'post'),
    array('method' => 'get', 'path' => '/api/', 'handler' => 'get'),
    array('method' => 'put', 'path' => '/api/', 'handler' => 'put'),
    array('method' => 'delete', 'path' => '/api/', 'handler' => 'delete')
  );

  public function __construct()
  {

    $this->db = new MySqlDb();
    $this->router = new Router();
  }

  private function set_router()
  {
    foreach ($this->routes as $route) {
      $this->router->create_route($route['method'], $route['path'], $route['handler']);
    }
  }

  public function init($request)
  {

    $this->set_router();
    $dbh = $this->db->connect();

    print $this->router->resolve($request);

    $dbh = null;
  }
}
