<?php

namespace app\models;

use app\models\Model;
use app\helpers\Sanitizer;

class User extends Model
{

  const TABLE = 'users';

  private ?string $name;
  private ?string $username;
  private ?string $email;

  public function __construct(\PDO $dbh = null, array $user = null)
  {
    $this->name = Sanitizer::sanitize_string($user['name'] ?? null);
    $this->username = Sanitizer::sanitize_string($user['username'] ?? null);
    $this->email = Sanitizer::sanitize_string($user['email'] ?? null);
    parent::__construct($dbh, $user);
  }

  public function get_name()
  {
    return $this->name;
  }

  public function set_name(string $name)
  {
    $this->name = Sanitizer::sanitize_string($name);
  }
  public function get_username()
  {
    return $this->username;
  }

  public function set_username(string $username)
  {
    $this->username = Sanitizer::sanitize_string($username);
  }
  public function get_email()
  {
    return $this->email;
  }

  public function set_email(string $email)
  {
    $this->email = Sanitizer::sanitize_string($email);
  }
}
