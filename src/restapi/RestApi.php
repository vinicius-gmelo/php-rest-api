<?php

namespace App\Api;

class RestAPI
{

  private DatabaseInterface $db;
  private EntryInterface $entry;
  private int $id;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function create($entry)
  {
    $this->db->create($entry);
  }

  public function retrieve()
  {
    $this->db->retrieve();
  }

  public function retrive($id)
  {
    $this->db->retrieve($id);
  }

  public function update($entry, $id)
  {
    $this->db->update($entry, $id);
  }

  public function delete($id)
  {
    $this->db->delete($id);
  }
}
