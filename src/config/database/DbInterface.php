<?php

namespace app\config\database;

interface DbInterface
{

  public function connect(): ?\PDO;
}
