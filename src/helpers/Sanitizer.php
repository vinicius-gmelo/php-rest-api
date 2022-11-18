<?php

namespace app\helpers;

use app\helpers\SanitizerInterface;

class Sanitizer implements SanitizerInterface
{

  public static function sanitize_string(?string $string): ?string
  {
    if (!empty($string) && !is_null($string)) {
      return htmlspecialchars(strip_tags($string));
    }
    return null;
  }

  public static function string_to_int(string $string): ?int
  {

    if (is_numeric($string) && !is_null($string)) {
      return (int) $string;
    }
    return null;
  }
}
