<?php
// untuk data siswa
// berkaitan dengan CRUD siswa
class Student extends Model
{
    private $lastErrorCode;

    public function getAll()
    {
        $sql    = "SELECT * FROM students ORDER BY id ASC";
        $result = $this->dbconn->query($sql);

        if ($result) {
            $students = [];
            while ($row = $result->fetch_object()) {
                $students[] = $row;
            }
            return $students;
        }

        return false;
    }


    public function getById($id)
    {
        $id     = $this->dbconn->real_escape_string($id);
        $sql    = "SELECT * FROM students WHERE id = '$id'";
        $result = $this->dbconn->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_object();
        }

        return false;
    }

    public function create($name, $nim, $address)
    {
        try {
            $name    = $this->dbconn->real_escape_string($name);
            $nim     = $this->dbconn->real_escape_string($nim);
            $address = $this->dbconn->real_escape_string($address);

            $checkSql    = "SELECT * FROM students WHERE nim = '$nim'";
            $checkResult = $this->dbconn->query($checkSql);

            if ($checkResult && $checkResult->num_rows > 0) {
                $this->lastErrorCode = 1062;
                return false;
            }

            $sql    = "INSERT INTO students (name, nim, address) VALUES ('$name', '$nim', '$address')";
            $result = $this->dbconn->query($sql);

            return $result;
        } catch (Exception $e) {
            $this->lastErrorCode = $this->dbconn->errno;
            return false;
        }
    }

    public function update($id, $name, $nim, $address)
    {
        try {
            $id      = $this->dbconn->real_escape_string($id);
            $name    = $this->dbconn->real_escape_string($name);
            $nim     = $this->dbconn->real_escape_string($nim);
            $address = $this->dbconn->real_escape_string($address);

            $checkSql    = "SELECT * FROM students WHERE nim = '$nim' AND id != '$id'";
            $checkResult = $this->dbconn->query($checkSql);

            if ($checkResult && $checkResult->num_rows > 0) {
                $this->lastErrorCode = 1062;
                return false;
            }

            $sql    = "UPDATE students SET name = '$name', nim = '$nim', address = '$address' WHERE id = '$id'";
            $result = $this->dbconn->query($sql);

            return $result;
        } catch (Exception $e) {
            $this->lastErrorCode = $this->dbconn->errno;
            return false;
        }
    }

    public function delete($id)
    {
        $id     = $this->dbconn->real_escape_string($id);
        $sql    = "DELETE FROM students WHERE id = '$id'";
        $result = $this->dbconn->query($sql);

        return $result;
    }

    public function getLastErrorCode()
    {
        return $this->lastErrorCode;
    }
}
