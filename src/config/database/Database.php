<?php

namespace app\config\database;

use app\config\database\DatabaseInterface;

abstract class Database implements DatabaseInterface
{

  const DATABASE = '';

  protected string $host;
  protected string $port;
  protected string $dbname;
  protected string $user;
  protected string $password;

  public \PDO $dbh;

  public function connect(): ?\PDO
  {
    try {
      $this->dbh = new \PDO(strtolower(static::DATABASE) . ":host={$this->host};port={$this->port};dbname={$this->dbname}", $this->user, $this->password);
      $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      return null;
    }

    return $this->dbh;
  }

  protected function set_db()
  {
    $this->host = getenv('DB_HOST');
    $this->port = getenv('DB_PORT');
    $this->dbname = getenv('DB_DBNAME');
    $this->user = getenv('DB_USER');
    $this->password = getenv('DB_PASSWORD');
  }
}
