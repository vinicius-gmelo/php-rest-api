<?php

namespace app\models;

interface ModelInterface
{

  public function create(): bool;
  public function retrieve(): ?array;
  public function retrieve_single(): ?static;
  public function delete(): bool;
  public function update(): bool;
}
