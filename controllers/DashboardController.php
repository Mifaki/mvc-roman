<?php
// untuk dashboard (dashboard utama, profil, settings, dll)
// untuk CRUD data siswa
// berkaitan dengan views/dashboard/*.php
class DashboardController extends Controller
{
    public function __construct()
    {
        session_start();
        if (! isset($_SESSION['user'])) {
            header("Location:?c=auth&m=login");
            exit();
        }
    }

    public function index()
    {
        $title = 'Dashboard';
        $this->loadView(
            "dashboard/index",
            [
                'title'    => $title,
                'username' => $_SESSION['user']['name'],
            ],
            'main'
        );
    }

    public function profile()
    {
        $title = 'User Profile';
        $this->loadView(
            "dashboard/profile",
            [
                'title'    => $title,
                'username' => $_SESSION['user']['name'],
                'user_id'  => $_SESSION['user']['id'],
            ],
            'main'
        );
    }

    public function getAllStudents()
    {
        $title        = 'Student List';
        $studentModel = $this->loadModel("student");
        $students     = $studentModel->getAll();

        $this->loadView(
            "dashboard/students/index",
            [
                'title'    => $title,
                'username' => $_SESSION['user']['name'],
                'students' => $students,
            ],
            'main'
        );
    }

    public function createStudent()
    {
        $title = 'Add Student';
        $this->loadView(
            "dashboard/students/create",
            [
                'title'    => $title,
                'username' => $_SESSION['user']['name'],
            ],
            'main'
        );
    }

    public function insertStudent()
    {
        $name    = $_POST['name'] ?? '';
        $nim     = $_POST['nim'] ?? '';
        $address = $_POST['address'] ?? '';

        $studentModel = $this->loadModel("student");
        $result       = $studentModel->create($name, $nim, $address);

        if ($result) {
            header("Location:?c=dashboard&m=getAllStudents");
            exit();
        } else {
            $errorCode    = $studentModel->getLastErrorCode();
            $errorMessage = "Gagal menambahkan data siswa";

            if ($errorCode == 1062) {
                $errorMessage = "Data siswa dengan NIM yang sama sudah ada";
            }

            $this->loadView(
                "dashboard/students/create",
                [
                    'title'    => 'Tambah Siswa',
                    'username' => $_SESSION['user']['name'],
                    'error'    => $errorMessage,
                    'name'     => $name,
                    'nim'      => $nim,
                    'address'  => $address,
                ],
                'main'
            );
        }
    }

    public function editStudent()
    {
        $title = 'Edit Student';
        $id    = $_GET['id'] ?? 0;

        if (! $id) {
            header("Location:?c=dashboard&m=getAllStudents");
            exit();
        }

        $studentModel = $this->loadModel("student");
        $student      = $studentModel->getById($id);

        if (! $student) {
            header("Location:?c=dashboard&m=getAllStudents");
            exit();
        }

        $this->loadView(
            "dashboard/students/edit",
            [
                'title'    => $title,
                'username' => $_SESSION['user']['name'],
                'student'  => $student,
            ],
            'main'
        );
    }

    public function updateStudent()
    {
        $id      = $_POST['id'] ?? 0;
        $name    = $_POST['name'] ?? '';
        $nim     = $_POST['nim'] ?? '';
        $address = $_POST['address'] ?? '';

        if (! $id) {
            header("Location:?c=dashboard&m=getAllStudents");
            exit();
        }

        $studentModel = $this->loadModel("student");
        $result       = $studentModel->update($id, $name, $nim, $address);

        if ($result) {
            header("Location:?c=dashboard&m=getAllStudents");
            exit();
        } else {
            $errorCode    = $studentModel->getLastErrorCode();
            $errorMessage = "Gagal mengubah data siswa";

            if ($errorCode == 1062) {
                $errorMessage = "Data siswa dengan NIM yang sama sudah ada";
            }

            $student          = new stdClass();
            $student->id      = $id;
            $student->name    = $name;
            $student->nim     = $nim;
            $student->address = $address;

            $this->loadView(
                "dashboard/students/edit",
                [
                    'title'    => 'Edit Student',
                    'username' => $_SESSION['user']['name'],
                    'error'    => $errorMessage,
                    'student'  => $student,
                ],
                'main'
            );
        }
    }

    public function deleteStudent()
    {
        $id = $_GET['id'] ?? 0;

        if (! $id) {
            header("Location:?c=dashboard&m=getAllStudents");
            exit();
        }

        $studentModel = $this->loadModel("student");
        $result       = $studentModel->delete($id);

        header("Location:?c=dashboard&m=getAllStudents");
        exit();
    }
}
