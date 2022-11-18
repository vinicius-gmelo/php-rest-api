<?php

namespace app\models;

use app\models\Model;
use app\helpers\Sanitizer;

class User extends Model
{

  const TABLE = 'users';

  public string $name;
  public string $username;
  public string $email;

  public function __construct(array $user)
  {
    $this->name = Sanitizer::sanitize_string($user['name']);
    $this->username = Sanitizer::sanitize_string($user['username']);
    $this->email = Sanitizer::sanitize_string($user['email']);
    $this->id = Sanitizer::string_to_int($user['id']);
    $this->created_at = Sanitizer::sanitize_string($user['created_at']);
  }
}
