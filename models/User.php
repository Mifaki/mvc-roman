<?php
// untuk model autentikasi
// berkaitan dengan login, register
class User extends Model {
  public function getByName($name) {
    $sql = "SELECT * FROM users WHERE name = '$name'";
    $result = $this->dbconn->query($sql);
    return $result->fetch_object();
  }

  public function create() {
    // todo: menambah user
    // 1. tambahkan parameter nama dan password
    // 2. lakukan hashing terhadap password
    // 3. masukkan data user ke dalam tabel users
    // 4. kembalikan hasil dari querynya
  }
}