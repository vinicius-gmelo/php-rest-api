<?php

namespace app\lib;

use app\lib\RestApiInterface;
use app\config\database\MySqlDb;
use app\models\Model;

class Api implements RestApiInterface
{
  private \PDO $dbh;

  public function __construct()
  {
  }

  public function post(Model $model): void
  {
    $this->db_connect();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $post_data = json_decode(file_get_contents('php://input'), true);
    $class = get_class($model);
    $entity = new $class($post_data);
    if ($entity::create($this->dbh, $entity)) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }

    $this->dbh = null;
  }

  public function get(array $request, Model $model): void
  {
    $this->db_connect();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    parse_str($request['QUERY_STRING'], $params);
    $id = $params['id'] ?? null;

    if ($id) {
      $entity = $model::retrieve_single($this->dbh, $id);
      $json = json_encode($entity);
      print $json;
    } else {
      $arr = $model::retrieve($this->dbh);
      $json = json_encode($arr);
      print $json;
    }

    $this->dbh = null;
  }

  public function put(Model $model): void
  {
    $this->db_connect();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $put_data = json_decode(file_get_contents('php://input'), true);
    $class = get_class($model);
    $entity = new $class($put_data);
    if ($entity::update($this->dbh, $entity)) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }

    $this->dbh = null;
  }

  public function delete(array $request, Model $model): void
  {

    $this->db_connect();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    parse_str($request['QUERY_STRING'], $params);
    $id = $params['id'] ?? null;

    if ($model::delete($this->dbh, $id)) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }

    $this->dbh = null;
  }

  private function db_connect()
  {
    $db = new MySqlDb();
    $this->dbh = $db->connect();
  }
}
