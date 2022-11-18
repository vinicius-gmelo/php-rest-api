<?php

namespace app\lib;

interface RestApiInterface
{

  public function post(): void;
  public function get(): void;
  public function put(): void;
  public function delete(): void;
}
