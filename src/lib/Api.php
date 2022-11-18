<?php

namespace app\lib;

use app\config\database\Database;
use app\lib\RestApiInterface;

class Api implements RestApiInterface
{
  private Database $db;
  private string $model;

  public function __construct(string $model, string $db)
  {
    $db = 'app\config\database\\' . ucfirst(strtolower($db));
    $this->db = new $db();
    $this->model = 'app\models\\' . ucfirst(strtolower($model));
  }

  public function post(): void
  {
    $dbh = $this->db_connect();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $post_data = json_decode(file_get_contents('php://input'), true);
    $entity = new $this->model($post_data);
    if ($entity::create($dbh, $entity)) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }

    $dbh = null;
  }

  public function get(int $id): void
  {
    $dbh = $this->db_connect();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($id) {
      $entity = $this->model::retrieve_single($dbh, $id);
      $json = json_encode($entity);
      print $json;
    } else {
      $arr = $this->model::retrieve($dbh);
      $json = json_encode($arr);
      print $json;
    }

    $dbh = null;
  }

  public function put(): void
  {
    $dbh = $this->db_connect();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $put_data = json_decode(file_get_contents('php://input'), true);
    $entity = new $this->model($put_data);
    if ($entity::update($dbh, $entity)) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }

    $dbh = null;
  }

  public function delete(int $id): void
  {

    $dbh = $this->db_connect();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    if ($this->model::delete($dbh, $id)) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }

    $dbh = null;
  }

  private function db_connect()
  {
    return $this->db->connect();
  }
}
