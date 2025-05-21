<?php
class Model
{
    protected $dbconn;

    public function __construct()
    {
        $host     = "localhost";
        $username = "root";
        $password = "admin123";
        $database = "mvc";

        $this->dbconn = new mysqli($host, $username, $password, $database);

        if ($this->dbconn->connect_error) {
            throw new Exception("Connection failed: " . $this->dbconn->connect_error);
        }
    }

    public function __destruct()
    {
        if ($this->dbconn) {
            $this->dbconn->close();
        }
    }
}
