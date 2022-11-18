<?php

namespace app\config\database;

use app\config\database\Database;

class Mysql extends Database
{
  const DATABASE = 'Mysql';

  public function __construct()
  {
    $this->set_db();
  }
}
