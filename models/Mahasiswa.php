<?php
class Mahasiswa
{
    private $pdo;
    private $table = 'mahasiswa';

    public function __construct($db)
    {
        $this->pdo = $db;
    }

    public function daftar($nim, $nama, $alamat, $fakultas, $prodi, $kelas, $tahun_akademik, $bukti_bayar)
    {
        try{
             $this->pdo->beginTransaction();

            // Buat Akun User Baru Otomatis
            $password = password_hash($nim, PASSWORD_DEFAULT);
            $tanggal_buat = date('Y-m-d H:i:s');
            $role = 'Mahasiswa';

            $query_user = "INSERT INTO user (username, password, role, status, created_at) VALUES (?, ?, ?, 'Aktif', ?)";
            $stmt_user = $this->pdo->prepare($query_user);
            $tambah = $stmt_user->execute([$nim, $password, $role, $tanggal_buat]);


            if ($tambah) {
                // Ambil ID User Baru yang telah dibuat
                $stmt_id = $this->pdo->prepare("SELECT id_user FROM user WHERE username = ?");
                $stmt_id->execute([$nim]);
                $id_user = $stmt_id->fetchColumn();


                // Simpan Data Mahasiswa ke Database
                $sql = "INSERT INTO {$this->table} (id_user, nim, nama_mahasiswa, alamat, id_fakultas, id_prodi, kelas, id_tahun, bukti_pembayaran, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$id_user, $nim, $nama, $alamat, $fakultas, $prodi, $kelas, $tahun_akademik, $bukti_bayar]);            
                $this->pdo->commit();
                return true;
            }
        
        } catch (PDOException $e) {
            $this->pdo->rollback();
            error_log("Error daftar mahasiswa: ". $e->getMessage());
        return false;
        }
    }
}
