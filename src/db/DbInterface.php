<?php

namespace app\db;

interface DbInterface
{

  public function connect(): \PDO;
  public function disconnect(): void;
}
