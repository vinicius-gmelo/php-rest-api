<?php

namespace app\models;

use app\models\ModelInterface;
use app\helpers\Sanitizer;

abstract class Model implements ModelInterface
{

  const TABLE = '';
  protected ?int $id;
  protected ?string $created_at;
  protected ?\PDO $dbh;

  public function __construct(?\PDO $dbh, ?array $data): void
  {
    $this->id = Sanitizer::string_to_int($data['id'] ?? null);
    $this->created_at = Sanitizer::sanitize_string($data['created_at'] ?? null);

    $this->dbh = $dbh ?? null;
  }

  public function create(): bool
  {
    $query = 'INSERT INTO ' . static::TABLE . ' SET ';

    $data = get_object_vars($this);

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

    $stmt = $this->dbh->prepare($query);

    try {
      $stmt->execute($data);
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }
  public function retrieve(): ?array
  {

    try {
      $rows = $this->dbh->query('SELECT * FROM ' . static::TABLE)->fetchAll(\PDO::FETCH_ASSOC);
      $data = array();

      foreach ($rows as $row) {
        array_push($data, new static(...array_values($row)));
      }
    } catch (\PDOException | \TypeError $e) {
      return null;
    }

    return $data;
  }
  public function retrieve_single(): ?static
  {

    $query = 'SELECT * FROM ' . static::TABLE . ' WHERE id=:id';

    try {
      $stmt = $this->dbh->prepare($query);
      $stmt->execute(array('id' => $this->id));
      $row = $stmt->fetch(\PDO::FETCH_ASSOC);
      $data = new static(...array_values($row));
    } catch (\PDOException | \TypeError $e) {
      return null;
    }

    return $data;
  }
  public function delete(): bool
  {

    $query = 'DELETE FROM ' . static::TABLE . ' WHERE id = :id';

    try {
      $stmt = $this->dbh->prepare($query);
      $stmt->execute(array('id' => $this->id));
      return true;
    } catch (\PDOException $e) {
      return false;
    }
  }
  public function update(): bool
  {

    $data = get_object_vars($this);

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
      $stmt = $this->dbh->prepare($query);
      $data['id'] = $this->id;
      $stmt->execute($data);
      return true;
    } catch (\PDOException $e) {
      return false;
    }
  }
}
