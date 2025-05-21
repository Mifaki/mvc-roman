<?php
// untuk login, register, logout
// berkaitan dengan views/auth/*.php
// password saat register menggunakan password_hash
// password saat login menggunakan password_verify
class AuthController extends Controller
{
    public function login()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            header("Location:?c=dashboard&m=index");
            exit();
        }
        $this->loadView("auth/login", ['title' => 'Login'], "auth");
    }

    public function loginProcess()
    {
        session_start();
        $title     = 'Login';
        $name      = $_POST['name'] ?? '';
        $password  = $_POST['password'] ?? '';
        $userModel = $this->loadModel("user");
        $user      = $userModel->getByName($name);
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = [
                'id'   => $user->id,
                'name' => $user->name,
            ];
            header("Location:?c=dashboard&m=index");
        } else {
            $this->loadView(
                "auth/login",
                [
                    'title' => $title,
                    'error' => 'Login gagal, cek username/password',
                ],
                'auth'
            );
        }
    }

    public function register()
    {
        session_start();
        if (isset($_SESSION['user'])) {
            header("Location:?c=dashboard&m=index");
            exit();
        }
        $this->loadView("auth/register", ['title' => 'Register'], "auth");
    }

    public function registerProcess()
    {
        $name            = $_POST['name'] ?? '';
        $password        = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];

        if (empty($name)) {
            $errors[] = "Username tidak boleh kosong";
        }

        if (empty($password)) {
            $errors[] = "Password tidak boleh kosong";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Password dan konfirmasi password tidak sama";
        }

        $userModel    = $this->loadModel("user");
        $existingUser = $userModel->getByName($name);

        if ($existingUser) {
            $errors[] = "Username sudah dipakai";
        }

        if (! empty($errors)) {
            $this->loadView(
                "auth/register",
                [
                    'title'  => 'Register',
                    'errors' => $errors,
                    'name'   => $name,
                ],
                'auth'
            );
            return;
        }

        $result = $userModel->create($name, $password);

        if ($result) {
            $this->loadView(
                "auth/login",
                [
                    'title'   => 'Login',
                    'success' => 'Registrasi berhasil. Silakan login.',
                ],
                'auth'
            );
        } else {
            $this->loadView(
                "auth/register",
                [
                    'title'  => 'Register',
                    'errors' => ['Registrasi gagal. Silakan coba lagi.'],
                    'name'   => $name,
                ],
                'auth'
            );
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location:?c=auth&m=login");
        exit();
    }
}
