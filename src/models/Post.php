<?php

namespace app\models;

use app\models\Model;
use app\helpers\Sanitizer;

class Post extends Model
{

  const TABLE = 'posts';

  public string $content;
  public string $author;

  public function __construct(array $post)
  {
    $this->content = Sanitizer::sanitize_string($post['content']);
    $this->author = Sanitizer::sanitize_string($post['author']);
    $this->id = Sanitizer::string_to_int($post['id']);
    $this->created_at = Sanitizer::sanitize_string($post['created_at']);
  }
}
