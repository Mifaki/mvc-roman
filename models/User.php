<?php
// untuk model autentikasi
// berkaitan dengan login, register
class User extends Model
{
    public function getByName($name)
    {
        $sql    = "SELECT * FROM users WHERE name = '$name'";
        $result = $this->dbconn->query($sql);
        return $result->fetch_object();
    }

    public function create($name, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $name = $this->dbconn->real_escape_string($name);

        $sql = "INSERT INTO users (name, password) VALUES ('$name', '$hashedPassword')";

        try {
            $result = $this->dbconn->query($sql);
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }
}
