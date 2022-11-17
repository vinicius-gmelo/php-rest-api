<?php

namespace app\models;

use app\models\Model;

class Post extends Model
{

  const TABLE = 'posts';

  public string $content;
  public string $author;

  public function __construct($content, $author, $id = null, $created_at = null)
  {

    $this->id = htmlspecialchars(strip_tags($id));
    $this->created_at = htmlspecialchars(strip_tags($created_at));
    $this->content = htmlspecialchars(strip_tags($content));
    $this->author = htmlspecialchars(strip_tags($author));
  }
}
