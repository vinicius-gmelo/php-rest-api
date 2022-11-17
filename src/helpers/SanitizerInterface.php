<?php

namespace app\helpers;

interface SanitizerInterface
{

  public static function sanitize_string(string $string): ?string;
  public static function string_to_int(string $string): ?int;
}
