<?php

namespace app\config\database;

use app\config\database\DbInterface;

abstract class Database implements DbInterface
{

  const DB = '';

  protected string $host;
  protected string $port;
  protected string $dbname;
  protected string $user;
  protected string $password;

  public \PDO $dbh;

  public function connect(): ?\PDO
  {
    try {
      $this->dbh = new \PDO(static::DB . ":host={$this->host};port={$this->port};dbname={$this->dbname}", $this->user, $this->password);
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
