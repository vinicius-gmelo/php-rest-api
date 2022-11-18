<?php

namespace app\lib;

interface RestApiInterface
{

  public function post(): void;
  public function get(int $id): void;
  public function put(): void;
  public function delete(int $id): void;
}
