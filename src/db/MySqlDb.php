<?php

namespace app\db;

use app\db\DbAbstract;

class MySqlDb extends DbAbstract
{
  const DB = 'mysql';

  public function __construct()
  {
    $this->set_db();
  }
}
