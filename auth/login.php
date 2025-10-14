<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">   
                            <div class="col-xl-12 col-lg-6">
                                <div class="p-5">
                                        <?php if (isset($_GET['pesan'])) {
                                            if ($_GET['pesan'] == "roleerror") {
                                                echo "<div class='alert alert-danger'>Role tidak dikenali</div>";
                                            } else if ($_GET['pesan'] == "logout") {
                                                echo "<div class='alert alert-success'>Anda telah berhasil logout</div>";
                                            } else if ($_GET['pesan'] == "belum_login") {
                                                echo "<div class='alert alert-danger'>Anda harus login untuk mengakses halaman</div>";
                                            } else if ($_GET['pesan'] == "gagal") {
                                                echo "<div class='alert alert-danger'>Login gagal! NIM/NIDN dan password salah!</div>";
                                            }
                                            else if($_GET['pesan'] == "input"){
                                                echo "<div class='alert alert-success'>Pendaftaran berhasil! Silakan login.</div>";
                                            }
                                            else if($_GET['pesan'] == "changed"){
                                                echo "<div class='alert alert-success'>Password berhasil diubah! Silakan login.</div>";
                                            }
                                        }?>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">LOG IN</h1>
                                    </div>
                                    <form class="user" method="post" action="../controllers/AuthController.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="username" name="username"
                                                placeholder="NIM / NIDN">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" placeholder="Password" name="password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user col-12">Login</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="ganti_password.php">Ubah Password</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="../views/mahasiswa/pendaftaran.php">Daftar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>s