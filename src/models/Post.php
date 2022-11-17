<?php

namespace app\models;

use app\models\Model;
use app\helpers\Sanitizer;

class Post extends Model
{

  const TABLE = 'posts';

  public string $content;
  public string $author;

  public function __construct($content, $author, $id = null, $created_at = null)
  {
    $this->content = Sanitizer::sanitize_string($content);
    $this->author = Sanitizer::sanitize_string($author);
    $this->id = Sanitizer::string_to_int($id);
    $this->created_at = Sanitizer::sanitize_string($created_at);
  }
}
