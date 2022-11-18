<?php

namespace app\lib;

use app\models\Model;

interface RestApiInterface
{

  public function post(Model $model): void;
  public function get(array $request, Model $model): void;
  public function put(Model $model): void;
  public function delete(array $request, Model $model): void;
}
