<?php

namespace app\models;

use app\models\AbstractModel;

class User extends AbstractModel
{

  const TABLE = 'users';

  private string $name;
  private string $username;
  private string $email;

  public function __construct(array $user)
  {

    $this->set_model($user);
  }
}
