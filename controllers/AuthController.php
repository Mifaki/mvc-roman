<?php
// untuk login, register, logout
// berkaitan dengan views/auth/*.php
// password saat register menggunakan password_hash
// password saat login menggunakan password_verify
class AuthController extends Controller {
  public function login() {
    session_start();
    if (isset($_SESSION['user'])) {
      header("Location:?c=dashboard&m=index");
      exit();
    }
    
    $this->loadView("auth/login", ['title' => 'Login'], "auth");
  }

  public function loginProcess() {
    session_start();

    $title = 'Login';

    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

    $userModel = $this->loadModel("user");
    $user = $userModel->getByName($name);

    if ($user && password_verify($password, $user->password)) {
      $_SESSION['user'] = [
        'id' => $user->id,
        'name' => $user->name
      ];
      header("Location:?c=dashboard&m=index");
    } else {
      $this->loadView(
        "auth/login", 
        [
          'title' => $title,
          'error' => 'Login gagal, cek username/password'
        ],
        'auth'
      );
    }
  }

  public function register() {
    // todo: menampilkan halaman register
    // 1. baca session, jika sudah ada session, maka lempar ke dashboard
    // 2. jika belum, tampilkan halaman register. gunakan layout 'auth'
  }

  public function registerProcess() {
    // todo: memproses register
    // 1. baca data yang dikirim dari form
    // 2. bandingkan antara password dengan konfirmasi password, 
    //    jika tidak sama, maka tampilkan pesan error
    // 3. cek data user di database, jika sudah ada, maka tampilkan pesan error
    // 4. jika semua aman, tampilkan halaman login. gunakan layout 'auth'
  }

  public function logout() {
    session_start();
    session_destroy();
    header("Location:?c=auth&m=login");
    exit();
  }
}