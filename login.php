<?php

session_start();
include 'config/app.php';


// Method Check Login 1
// if (isset($_POST['masuk'])) {
//     // mysqli_real_escape_string berfungsi untuk mengamankan database by SQLI connect
//     // ambil input username dan password
//     $nama = mysqli_real_escape_string($db, $_POST['nama']);
//     $password = mysqli_real_escape_string($db, $_POST['password']);

//     // Check Username
//     $result = mysqli_query($db, "SELECT * FROM login WHERE nama = '$nama'");

//     // Jika ada Usernya
//     if (mysqli_num_rows($result) == 1) {
//         // Check Password
//         $hasil = mysqli_fetch_assoc($result);

//         if (password_verify($password, $hasil['password'])) {
//             // Set Session
//             $_SESSION['login'] = true;
//             $_SESSION['id_user'] = $hasil['id_user'];
//             $_SESSION['nama'] = $hasil['nama'];
//             $_SESSION['alamat'] = $hasil['alamat'];
//             $_SESSION['email'] = $hasil['email'];
//             $_SESSION['level'] = $hasil['level'];

//             // Jika LOGIN benar diarahkan ke file index.php
//             header("location: index.php");
//             exit;
//         }
//     }
//     // Jika tidak ada usernya/login salah
//     $error = true;
// }

// Cek "Jika Sudah Login tidak bisa mengakses login.php -> redirect -> index.php
// if (!isset($_SESSION['login'])) {
// } else {
//     header('location:index.php');
// };

// Method Check Login 2, apakah tombol login ditekan
if (isset($_POST['masuk'])) {

    // Ambil Data Username dan Password 
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    // Check Username
    $result = mysqli_query($db, "SELECT * FROM login WHERE nama = '$nama' and password='$password'");

    $hitung = mysqli_num_rows($result);
    // Jika ada Email dan Password
    if ($hitung > 0) {
        $_SESSION['login'] = true;
        header('Location:index.php');
    } else {
        $error = true;
    }
    // Jika tidak ada usernya/login salah
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Sign in</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">



    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="icon" href="assets/other-img/login2.jpg">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin">
        <form action="" method="POST">
            <img class="mb-4" src="assets/other-img/Login2.jpg" alt="" width="100" height="80">
            <h1 class="h3 mb-3 fw-normal">Login</h1>
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger text center">
                    <b>Username / Password SALAH !!</b>
                </div>
            <?php endif; ?>
            <div class="form-floating">
                <input type="text" name="nama" class="form-control" id="floatingInput" placeholder="Username..." required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password..." required>
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="masuk">Login</button>
            <a href="guest.php" class="w-100 btn btn-lg btn-primary mt-3">Guest Login</a>
            <p class="mt-5 mb-3 text-muted">Copyright &copy; WayTech <?= date('Y') ?></p>
        </form>
    </main>

</body>

</html>