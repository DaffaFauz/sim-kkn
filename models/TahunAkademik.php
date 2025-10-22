<?php 
class TahunAkademik{
    private $pdo;
    private $table = 'tahun_akademik';

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getAll(){
        try{
            $stmt = $this->pdo->query("SELECT * FROM tahun_akademik");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            error_log("Error get all tahun akademik: ". $e->getMessage());
            return false;
        }
    }

    public function tambah($tahun){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO tahun_akademik (tahun_akademik, status) VALUES (?, 'Aktif')");
            $stmt->execute([$tahun]);
            return true;
        }catch(Exception $e){
            error_log("Error tambah tahun akademik: ". $e->getMessage());
            return false;
        }
    }

    public function ubah($id){
        try{
            $stmt = $this->pdo->prepare("UPDATE {$this->table} SET status = ? WHERE id_tahun = ?");
            // Ambil status saat ini
            $currentStmt = $this->pdo->prepare("SELECT status FROM {$this->table} WHERE id_tahun = ?");
            $currentStmt->execute([$id]);
            $currentStatus = $currentStmt->fetchColumn();

            $newStatus = ($currentStatus === 'Aktif') ? 'Nonaktif' : 'Aktif';
            $stmt->execute([$newStatus, $id]);
            return true;
        }catch(PDOException $e){
            error_log("Error ubah status tahun akademik: ". $e->getMessage());
            return false;
        }
    }

    public function hapus($id){
        try{
            $check = $this->pdo->query("SELECT status FROM {$this->table} WHERE id_tahun = $id")->fetchColumn();
            if($check === 'Aktif'){
                return false; // Tidak boleh hapus tahun akademik yang aktif
            }
            $stmt = $this->pdo->prepare("DELETE FROM tahun_akademik WHERE id_tahun = ?");
            $stmt->execute([$id]);
            return true;
        }catch(PDOException $e){
            error_log("Error hapus tahun akademik: ". $e->getMessage());
            // Cek jika error disebabkan oleh foreign key constraint (kode error 1451 untuk MySQL)
            if($e->getCode() == '23000'){
                return "Constraint";
            }
            return false;
        }
    }
}