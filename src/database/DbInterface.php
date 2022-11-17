<?php

namespace app\database;

interface DbInterface
{

  public function connect(): ?\PDO;
}
