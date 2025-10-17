<?php
class Dosen{
    private $pdo;
    private $table = 'dosen';

    public function __construct($db){
        $this->pdo = $db;
    }

    public function tambah($nidn, $nama_dosen, $id_prodi, $jabatan){
        try{
            $sql = "INSERT INTO {$this->table} (nidn, nama_dosen, id_prodi, jabatan) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nidn, $nama_dosen, $id_prodi, $jabatan]);
            $id_dosen = $this->pdo->lastInsertId();
            if($id_dosen && $jabatan !== 'Dosen'){
                $sql = "INSERT INTO user (username, password, role, status, created_at) VALUES (?, ?, ?, 'Aktif', ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$nidn, password_hash($nidn, PASSWORD_DEFAULT), $jabatan, date('Y-m-d H:i:s')]);
            }
            return true;
        }catch(Exception $e){
            error_log("Error tambah dosen: ". $e->getMessage());
            return false;
        }
    }
}
?>