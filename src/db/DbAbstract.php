<?php

namespace app\db;

use app\db\DbInterface;

abstract class DbAbstract implements DbInterface
{

  protected string $host;
  protected string $port;
  protected string $dbname;
  protected string $user;
  protected string $password;

  public \PDO $dbh;
  const DB = self::DB;

  public function connect(): \PDO
  {
    try {
      $this->dbh = new \PDO(self::DB . ":host={$this->host};port={$this->port};dbname={$this->dbname}", $this->username, $this->password);
      $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo 'Connection Error: ' . $e->getMessage();
    }

    return $this->dbh;
  }

  public function disconnect(): void
  {
    $this->dbh = null;
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
