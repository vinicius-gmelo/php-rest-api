<?php

namespace app\lib;

use app\config\database\Database;
use app\lib\RestApiInterface;
use app\models\Model;

class Api implements RestApiInterface
{
  private Database $db;
  private Model $model;

  public function __construct($model, $db)
  {
    $this->model = $model;
    $this->db = $db;
  }

  public function post(): void
  {
    $dbh = $this->db->connect();

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $post_data = json_decode(file_get_contents('php://input'), true);
    $model = get_class($this->model);
    if ((new $model($dbh, $post_data))->create()) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }

    $dbh = null;
  }

  public function get(): void
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $dbh = $this->db->connect();
    $model = get_class($this->model);
    parse_str($_SERVER['QUERY_STRING'], $params);
    $id = $params['id'] ?? null;

    if ($id) {
      $json = json_encode((new $model($dbh, ['id' => $id]))->retrieve_single());
      print $json;
    } else {
      $json = json_encode((new $model($dbh))->retrieve());
      print $json;
    }

    $dbh = null;
  }

  public function put(): void
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $dbh = $this->db->connect();
    $put_data = json_decode(file_get_contents('php://input'), true);
    $model = get_class($this->model);

    if ((new $model($dbh, $put_data))->update()) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }

    $dbh = null;
  }

  public function delete(): void
  {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $dbh = $this->db->connect();
    parse_str($_SERVER['QUERY_STRING'], $params);
    $id = $params['id'] ?? null;
    $model = get_class($this->model);

    if ((new $model($dbh, ['id' => $id]))->delete()) {
      http_response_code(200);
    } else {
      http_response_code(400);
    }

    $dbh = null;
  }
}
