<?php

namespace app\database;

use app\database\Database;

class MySqlDb extends Database
{
  const DB = 'mysql';

  public function __construct()
  {
    $this->set_db();
  }
}
