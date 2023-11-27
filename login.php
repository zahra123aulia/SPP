<?php
include 'koneksi.php';
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $cek_petugas = mysqli_query($koneksi, "SELECT * FROM petugas WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($cek_petugas) > 0) {
        $_SESSION['petugas'] = mysqli_fetch_array($cek_petugas);
        echo '<script>alert("Selamat, Anda Berhasil Login")location.href="index.php";</script>';
    } else {
        $cek_siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$username' AND password='$password'");

        if (mysqli_num_rows($cek_siswa) > 0) {
            $_SESSION['petugas'] = mysqli_fetch_array($cek_siswa);
            echo '<script>alert("Anda Berhasil Login");location.href="index.php";</script>';
        } else {
            echo '<script>alert("Username Atau Password Salah");location.href="login.php";</script>';
        }
    }
}

if (!empty($_SESSION['petugas'])) {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Pembayaran SPP</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body class="bg-gradient-light" style="background-image: url('https://images.alphacoders.com/561/561157.jpg'); background-size: cover; background-position: center;">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Login!</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="mb-3">
                                            <label class="form-group">Username/NISN</label>
                                            <input type="text" name="username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukkan Username/NISN Anda...">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-group">Password</label>
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputEmail" placeholder="Masukkan Password Anda...">
                                        </div>
                                        <div class="from-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>