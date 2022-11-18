<?php

namespace app\models;

use app\models\Model;
use app\helpers\Sanitizer;

class Post extends Model
{

  const TABLE = 'posts';

  private ?string $content;
  private ?string $author;

  public function __construct(\PDO $dbh = null, array $post = null)
  {
    $this->content = Sanitizer::sanitize_string($post['content'] ?? null);
    $this->author = Sanitizer::sanitize_string($post['author'] ?? null);
    parent::__construct($dbh, $post);
  }

  public function get_content()
  {
    return $this->content;
  }

  public function set_content(string $content)
  {
    $this->content = Sanitizer::sanitize_string($content);
  }

  public function get_author()
  {
    return $this->author;
  }

  public function set_author(string $author)
  {
    $this->author = Sanitizer::sanitize_string($author);
  }
}
