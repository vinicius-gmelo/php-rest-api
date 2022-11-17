<?php

namespace app\router;

interface RouterInterface
{

  public function route_exists(string $method, string $path): bool;
  public function create_route(string $method, string $path, string $handler): bool;
  public function delete_route(string $method, string $path): bool;
  public function update_route(string $method, string $path, string $handler): bool;
  public function resolve(array $request): string;
}
