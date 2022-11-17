<?php

namespace app\models;

use app\models\Model;

class User extends Model
{

  const TABLE = 'users';

  public string $name;
  public string $username;
  public string $email;

  public function __construct($name, $username, $email, $id = null, $created_at = null)
  {
    $this->name = htmlspecialchars(strip_tags($name));
    $this->username = htmlspecialchars(strip_tags($username));
    $this->email = htmlspecialchars(strip_tags($email));
    $this->id = htmlspecialchars(strip_tags($id));
    $this->created_at = htmlspecialchars(strip_tags($created_at));
  }
}
