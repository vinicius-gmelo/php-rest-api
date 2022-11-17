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

  public function __construct($name, $username, $email, $id = null, $created_at = null)
  {
    $this->name = Sanitizer::sanitize_string($name);
    $this->username = Sanitizer::sanitize_string($username);
    $this->email = Sanitizer::sanitize_string($email);
    $this->id = Sanitizer::string_to_int($id);
    $this->created_at = Sanitizer::sanitize_string($created_at);
  }
}
