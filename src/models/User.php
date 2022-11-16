<?php


namespace app\models;

use app\models\ModelInterface;
use app\db\DbAbstract;


class User implements ModelInterface
{

  const TABLE = 'users';

  private ?int $id;
  private string $name;
  private string $surname;
  private string $username;
  private string $email;
  private int $created_at;
  private int $last_accessed;
  private string $profile_photo;

  public static function create(\PDO $dbh, ModelInterface $model): bool
  {

    $query = 'INSERT INTO ' . self::TABLE . ' SET name = :name, surname = :surname, username = :username, email = :email, created_at = :created_at, last_accessed = :last_accessed, profile_photo = :profile_photo';

    $stmt = $dbh->prepare($query);

    $stmt->bindParam(':name', $model->name);
    $stmt->bindParam(':surname', $model->surname);
    $stmt->bindParam(':username', $model->username);
    $stmt->bindParam(':email', $model->email);
    $stmt->bindParam(':created_at', $model->created_at);
    $stmt->bindParam(':last_accessed', $model->last_accessed);
    $stmt->bindParam(':profile_photo', $model->profile_photo);

    try {
      $stmt->execute();
      return true;
    } catch (\Exception $e) {
      print $e->getMessage();
      return false;
    }
  }

  public static function retrieve(\PDO $dbh): ?array
  {

    try {
      $users = $dbh->query('SELECT * FROM ' . self::TABLE)->fetchAll();
      $arr = array();

      foreach ($users as $user) {
        array_push($arr, new self($user));
      }
    } catch (\Exception $e) {
      print $e->getMessage();
    }

    return $arr;
  }
  public static function retrieve_single(\PDO $dbh, int $id): ModelInterface
  {
    $id = htmlspecialchars(strip_tags($id));

    $query = 'SELECT * FROM ' . self::TABLE . ' WHERE id=:id';
    $stmt = $dbh->prepare($query);

    $stmt->bindParam(':id', $id);

    try {
      $stmt->execute();
      $user = new self($stmt->fetch(\PDO::FETCH_ASSOC));
    } catch (\Exception $e) {
      print $e->getMessage();
    }

    return $user;
  }

  public static function delete(\PDO $dbh, int $id): bool
  {
    $id = htmlspecialchars(strip_tags($id));

    $query = 'DELETE FROM ' . self::TABLE . ' WHERE id = :id';

    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':id', $id);

    try {
      $stmt->execute();
      return true;
    } catch (\Exception $e) {
      print $e->getMessage();
      return false;
    }
  }

  public static function update(\PDO $dbh, ModelInterface $model): bool
  {

    $query = 'UPDATE ' . self::TABLE . ' SET name = :name, surname = :surname, username = :username, email = :email, created_at = :created_at, last_accessed = :last_accessed, profile_photo = :profile_photo WHERE id = :id';

    $stmt = $dbh->prepare($query);

    $stmt->bindParam(':id', $model->id);
    $stmt->bindParam(':name', $model->name);
    $stmt->bindParam(':surname', $model->surname);
    $stmt->bindParam(':username', $model->username);
    $stmt->bindParam(':email', $model->email);
    $stmt->bindParam(':created_at', $model->created_at);
    $stmt->bindParam(':last_accessed', $model->last_accessed);
    $stmt->bindParam(':profile_photo', $model->profile_photo);

    try {
      $stmt->execute();
      return true;
    } catch (\Exception $e) {
      print $e->getMessage();
      return false;
    }
  }

  public function __construct(array $user = array())
  {

    $this->set_user($user);
  }

  public function set_user(array $user): void
  {

    if (isset($user['id'])) {
      $this->id = htmlspecialchars(strip_tags($user['id']));
    } else {
      $this->id = null;
    }
    $this->name = htmlspecialchars(strip_tags($user['name']));
    $this->surname = htmlspecialchars(strip_tags($user['surname']));
    $this->username = htmlspecialchars(strip_tags($user['username']));
    $this->email = htmlspecialchars(strip_tags($user['email']));
    $this->created_at = htmlspecialchars(strip_tags($user['created_at']));
    $this->last_accessed = htmlspecialchars(strip_tags($user['last_accessed']));
    $this->profile_photo = htmlspecialchars(strip_tags($user['profile_photo']));
  }
}
