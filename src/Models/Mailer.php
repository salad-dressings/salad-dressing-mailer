<?php

namespace Salad\Dressing\Mailer\Models;

use Salad\Core\Application;

class Mailer
{
  protected $App;
  
  public function __construct()
  {
    $this->App = Application::$app;
  }

  public function findById($id)
  {
    return $this->App->db->fetch("SELECT * FROM dressing_mailer WHERE id = :id", [':id' => $id]) ?? [];
  }

  public function updateConfig($data)
  {
    return $this->App->db->execute("UPDATE dressing_mailer SET host = :host, username = :username, password = :password, encryption = :encryption, port = :port, address =:address WHERE id = 1", $data);
  }

  public function createConfig($data)
  {
    return $this->App->db->execute("INSERT INTO dressing_mailer (id, host, username, password, encryption, port, address) VALUES (1, :host, :username, :password, :encryption, :port, :address); ", $data);
  }
}
