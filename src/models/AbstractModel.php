<?php

namespace app\models;

use app\models\ModelInterface;

abstract class AbstractModel implements ModelInterface
{

  const TABLE = self::TABLE;
  protected ?int $id;
  protected ?int $created_at;

  public static function create(\PDO $dbh, self $model): bool
  {
    $query = 'INSERT INTO ' . self::TABLE . ' SET ';

    $vars = $model->get_vars();
    unset($vars['id']);
    unset($vars['created_at']);

    $fields = array_keys($vars);

    for ($i = 0; $i < count($fields); $i++) {
      $field = $fields[$i];
      $query .= "${field} = :${field}";
      if ($i < count($fields) - 1) {
        $query .= ', ';
      }
    }

    $stmt = $dbh->prepare($query);

    foreach ($vars as $field => $value) {
      $stmt->bindParam(":${field}", $value);
    }

    try {
      $stmt->execute();
      return true;
    } catch (\Exception $e) {
      print $e->getMessage();
      return false;
    }
  }
  public static function retrieve(\PDO $dbh): ?array
  {

    try {
      $rows = $dbh->query('SELECT * FROM ' . self::TABLE)->fetchAll();
      $arr = array();

      foreach ($rows as $row) {
        array_push($arr, new self($row));
      }
    } catch (\Exception $e) {
      print $e->getMessage();
    }

    return $arr;
  }
  public static function retrieve_single(\PDO $dbh, int $id): ?self
  {

    $id = htmlspecialchars(strip_tags($id));

    $query = 'SELECT * FROM ' . self::TABLE . ' WHERE id=:id';
    $stmt = $dbh->prepare($query);

    $stmt->bindParam(':id', $id);

    try {
      $stmt->execute();
      $row = new self($stmt->fetch(\PDO::FETCH_ASSOC));
    } catch (\Exception $e) {
      print $e->getMessage();
    }

    return $row;
  }
  public static function delete(\PDO $dbh, int $id): bool
  {

    $id = htmlspecialchars(strip_tags($id));

    $query = 'DELETE FROM ' . self::TABLE . ' WHERE id = :id';

    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':id', $id);

    try {
      $stmt->execute();
      return true;
    } catch (\Exception $e) {
      print $e->getMessage();
      return false;
    }
  }
  public static function update(\PDO $dbh, self $model): bool
  {

    $vars = $model->get_vars();

    unset($vars['id']);
    unset($vars['created_at']);

    $fields = array_keys($vars);

    $query = 'UPDATE ' . self::TABLE . ' SET ';

    for ($i = 0; $i < count($fields); $i++) {
      $field = $fields[$i];
      $query .= "${field} = :${field}";
      if ($i < count($fields) - 1) {
        $query .= ', ';
      }
    }

    $query .= ' WHERE id :id';

    $stmt = $dbh->prepare($query);

    $stmt->bindParam(':id', $model->id);

    foreach ($vars as $field => $value) {
      $stmt->bindParam(":${field}", $value);
    }

    try {
      $stmt->execute();
      return true;
    } catch (\Exception $e) {
      print $e->getMessage();
      return false;
    }
  }

  private function get_vars(): array
  {
    return get_object_vars($this);
  }

  protected function set_model(array $model): void
  {

    if (isset($model['id']) && isset($model['created_at'])) {
      $this->id = htmlspecialchars(strip_tags($model['id']));
      $this->created_at = htmlspecialchars(strip_tags($model['created_at']));
    } else {
      $this->id = null;
      $this->created_at = null;
    }

    unset($model['id']);
    unset($model['created_at']);

    try {
      foreach ($model as $key => $value) {
        $this->$key = $value;
      }
    } catch (\Exception $e) {

      print $e->getMessage();
    }
  }
}
