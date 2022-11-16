<?php

namespace app\router;

interface RouterInterface
{

  public function route_exists(string $method, string $path): bool;
  public function create_route(string $method, string $path, string $handler): array;
  public function delete_route(string $method, string $path): array;
  public function update_route(string $method, string $path, string $handler): bool;
  public function get_routes(): array;
  public function resolve(array $request): string;
}
