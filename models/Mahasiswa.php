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

    public function getAll(){
        try{
            $sql = "SELECT * FROM {$this->table} m INNER JOIN prodi p ON m.id_prodi = p.id_prodi INNER JOIN fakultas f on m.id_fakultas = f.id_fakultas INNER JOIN tahun_akademik t ON m.id_tahun = t.id_tahun WHERE m.status = 'Diverifikasi Kaprodi' OR m.status = 'Diverifikasi' AND t.status = 'Aktif'";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e){
            error_log("Error get all lokasi: ". $e->getMessage());
            return false;
        }
    }

    public function filter($prodi, $verifikasi){
            try{
            $sql = "SELECT * FROM mahasiswa LEFT JOIN prodi ON mahasiswa.id_prodi = prodi.id_prodi WHERE 1=1";
            $params = [];

            if(!empty($prodi)){
                $sql .= " AND nama_prodi = ?";
                $params[] = $prodi;
            }

            if(!empty($verifikasi)){
                $sql .= " AND status = ?";
                $params[] = $verifikasi;
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $e){
            error_log("Error filter lokasi: ". $e->getMessage());
            return false;
        }
    }

    public function hapus($id){
        try{
            $sql = "DELETE FROM {$this->table} WHERE id_mahasiswa = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            // $this->pdo->commit();
            return true;
        }catch(Exception $e){
            $this->pdo->rollback();
            error_log("Error hapus lokasi: ". $e->getMessage());
            return false;
        }
    }

}
