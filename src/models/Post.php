<?php

namespace app\models;

use app\models\AbstractModel;

class Post extends AbstractModel
{

  const TABLE = 'posts';

  private string $content;
  private string $author;

  public function __construct(array $post)
  {

    $this->set_model($post);
  }
}
