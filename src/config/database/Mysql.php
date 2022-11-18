<?php

namespace app\config\database;

use app\config\database\Database;

class MySqlDb extends Database
{
  const DB = 'mysql';

  public function __construct()
  {
    $this->set_db();
  }
}
