<?php

namespace app\config\database;

interface DatabaseInterface
{

  public function connect(): ?\PDO;
}
