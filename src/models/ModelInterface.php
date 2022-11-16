<?php

namespace app\models;

interface ModelInterface
{

  public static function create(\PDO $dbh, AbstractModel $model): bool;
  public static function retrieve(\PDO $dbh): ?array;
  public static function retrieve_single(\PDO $dbh, int $id): ?self;
  public static function delete(\PDO $dbh, int $id): bool;
  public static function update(\PDO $dbh, AbstractModel $model): bool;
}
