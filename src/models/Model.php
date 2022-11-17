<?php

namespace app\models;

use app\models\ModelInterface;

abstract class Model implements ModelInterface
{

  const TABLE = '';
  protected ?string $id;
  protected ?string $created_at;

  public static function create(\PDO $dbh, self $entity): bool
  {
    $query = 'INSERT INTO ' . static::TABLE . ' SET ';

    $data = $entity->get_vars();

    unset($data['id']);
    unset($data['created_at']);

    $fields = array_keys($data);

    for ($i = 0; $i < count($fields); $i++) {
      $field = $fields[$i];
      $query .= "${field} = :${field}";
      if ($i < count($fields) - 1) {
        $query .= ', ';
      }
    }

    $stmt = $dbh->prepare($query);

    try {
      $stmt->execute($data);
      return true;
    } catch (\Exception $e) {
      print $e->getMessage();
      return false;
    }
  }
  public static function retrieve(\PDO $dbh): ?array
  {

    try {
      $rows = $dbh->query('SELECT * FROM ' . static::TABLE)->fetchAll(\PDO::FETCH_ASSOC);
      $entities = array();

      foreach ($rows as $row) {
        array_push($entities, new static(...array_values($row)));
      }
    } catch (\PDOException | \TypeError $e) {
      return null;
    }

    return $entities;
  }
  public static function retrieve_single(\PDO $dbh, int $id): ?self
  {

    $id = htmlspecialchars(strip_tags($id));

    $query = 'SELECT * FROM ' . static::TABLE . ' WHERE id=:id';

    try {
      $stmt = $dbh->prepare($query);
      $stmt->execute(array('id' => $id));
      $row = $stmt->fetch(\PDO::FETCH_ASSOC);
      $entity = new static(...array_values($row));
    } catch (\PDOException | \TypeError $e) {
      return null;
    }

    return $entity;
  }
  public static function delete(\PDO $dbh, int $id): bool
  {

    $id = htmlspecialchars(strip_tags($id));

    $query = 'DELETE FROM ' . static::TABLE . ' WHERE id = :id';


    try {
      $stmt = $dbh->prepare($query);
      $stmt->execute(array('id' => $id));
      return true;
    } catch (\PDOException $e) {
      print $e->getMessage();
      return false;
    }
  }
  public static function update(\PDO $dbh, self $entity): bool
  {

    $data = $entity->get_vars();

    unset($data['id']);
    unset($data['created_at']);

    $fields = array_keys($data);

    $query = 'UPDATE ' . static::TABLE . ' SET ';

    for ($i = 0; $i < count($fields); $i++) {
      $field = $fields[$i];
      $query .= "${field} = :${field}";
      if ($i < count($fields) - 1) {
        $query .= ', ';
      }
    }

    $query .= ' WHERE id = :id';



    try {
      $stmt = $dbh->prepare($query);
      $data['id'] = $entity->id;
      $stmt->execute($data);
      return true;
    } catch (\PDOException $e) {
      print $e->getMessage();
      return false;
    }
  }

  private function get_vars(): array
  {
    return get_object_vars($this);
  }
}
