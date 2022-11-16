<?php

namespace app\db;

use app\db\DbAbstract;

class MySqlDb extends DbAbstract
{
  const DB = 'mysql';

  public function __construct(array $config = array())
  {
    $this->set_db($config);
  }

  public function set_db(array $config)
  {

    $this->host = $config['host'];
    $this->port = $config['port'];
    $this->dbname = $config['dbname'];
    $this->user = $config['user'];
    $this->password = $config['password'];
  }
}
