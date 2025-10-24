<?php
session_start();

require_once '../../config/db.php';

// Mendapatkan data fakultas
$getFakultas = $pdo->prepare("SELECT id_fakultas, nama_fakultas FROM fakultas");
$getFakultas->execute();
$fakultas = $getFakultas->fetchAll(PDO::FETCH_ASSOC);

// Mendapatkan data prodi berdasarkan fakultas (jika ada)

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KKN MU | Daftar</title>

    <!-- Custom fonts for this template-->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5 col-lg-6 mx-auto">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none"></div>
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Daftar</h1>
                            </div>
                            <?php if (isset($_SESSION['msg'])): ?>
                                <div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['msg'] ?>
                               </div>
                            <?php unset($_SESSION['msg']);?>
                            <?php endif; ?>
                            <form class="user" method="post" action="../../controllers/MahasiswaController.php" enctype="multipart/form-data">

                                <!-- NIM -->
                                <div class="form-group">
                                    <label for="nim">NIM</label>
                                    <input type="number" class="form-control" id="nim" name="nim"
                                        placeholder="NIM" value="">
                                    <div class="invalid-feedback">NIM harus diisi.</div>
                                </div>

                                <!-- Nama Mahasiswa -->
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Nama" value="">
                                    <div class="invalid-feedback">Nama harus diisi.</div>
                                </div>

                                <!-- Alamat -->
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        placeholder="alamat" value="">
                                    <div class="invalid-feedback">Alamat harus diisi.</div>
                                </div>
                                
                                <!-- Alamat -->
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                        <option selected value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <div class="invalid-feedback">Jenis Kelamin harus diisi.</div>
                                </div>

                                <!-- Fakultas -->
                                <div class="form-group">
                                    <label for="fakultas">Fakultas</label>
                                    <select name="fakultas" class="form-control" id="fakultas">
                                        <option selected value="">-- Pilih Fakultas --</option>
                                        <?php foreach($fakultas as $row): ?>
                                        <option value="<?= $row['id_fakultas'] ?>"><?= $row['nama_fakultas'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Fakultas harus diisi.</div>
                                </div>

                                <!-- Jurusan / Prodi -->
                                <div class="form-group">
                                    <label for="prodi">Prodi</label>
                                    <select name="prodi" class="form-control" id="prodi">
                                        <option selected disabled value="">-- Pilih Prodi --</option>
                                    </select>
                                    <div class="invalid-feedback">Prodi harus diisi.</div>
                                </div>

                                <!-- Kelas -->
                                <div class="form-group">
                                    <label for="kelas">Kelas</label>
                                    <select name="kelas" class="form-control" id="kelas">
                                        <option value="Reguler">Reguler</option>
                                        <option value="Non Reguler">Non Reguler</option>
                                    </select>
                                    <div class="invalid-feedback">Kelas harus diisi.</div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user col-12" name="daftar">Daftar</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="../../auth/login.php">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <script>
        // update file input label with selected file name
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.getElementById('bukti_bayar');
            if (input) {
                input.addEventListener('change', function(e) {
                    var fileName = '';
                    if (this.files && this.files.length > 0) {
                        fileName = this.files[0].name;
                    }
                    var label = this.closest('.custom-file').querySelector('.custom-file-label');
                    if (label) label.textContent = fileName || 'Pilih file';
                });
            }
        });
    </script>

    <script>
        // load option prodi
        $(document).ready(function(){
            $('#fakultas').on('change', function(){
            // Mendapatkan input fakultas
            var id_fakultas = $('#fakultas').val();
            $('#prodi').html(`<option selected disabled value="">-- Pilih Prodi --</option>`);

            if(id_fakultas){
                $.ajax({
                    url: '../../controllers/MahasiswaController.php',
                    type: 'POST',
                    data: {fakultas: id_fakultas},
                    dataType: 'json',
                    success: function(response){
                        if(response.length > 0){
                            $.each(response, function(index, item){
                                $('#prodi').append($('<option>', {
                                    value: item.id_prodi,
                                    text: item.nama_prodi
                                }));
                            })
                        } else{
                            $('#prodi').append('<option disabled>Tidak ada Prodi</option>');
                        }
                    },
                    error: function(xhr, status, error){
                        console.log("AJAX Error:" + error);
                        alert("Gagal memuat data")
                    }
                })
            }      
            })

        })
    </script>

    <script>
        // Validasi input
        $(document).ready(function(){
            const form = document.querySelector('form.user');
            form.addEventListener('submit', function(event){
                let isvalid = true;
                const fields = ['nim', 'nama', 'alamat', 'fakultas', 'prodi', 'kelas', 'thn_akademik', 'bukti_bayar'];
                fields.forEach(function(field){
                    const input = document.getElementById(field);
                    if(input.type === 'file'){
                        if(!input.files.length){
                            input.classList.add('is-invalid');
                            isvalid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    }
                    if(!input.value){
                        input.classList.add('is-invalid');
                        isvalid = false;
                    } else{
                        input.classList.remove('is-invalid');
                    }
                })
                if(isvalid){
                    $('button[name="daftar"]').click();
                } else{
                    event.preventDefault();
                    alert('Semua field harus diisi!');
                }
            })
        })
    </script>


</body>

</html>