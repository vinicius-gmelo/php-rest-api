<?php

namespace app\api;

abstract class AbstractEntry
{

  abstract protected function json_encode(): string;

  public function json_decode(): array
  {
    return json_decode($this->json);
  }
}
