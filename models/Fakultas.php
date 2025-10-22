<?php
class Fakultas {
    private $pdo;
    private $table = 'fakultas';

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function tambah($nama_fakultas, $kode_fakultas){
        try{
            $sql = "INSERT INTO {$this->table} (kode_fakultas, nama_fakultas) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$kode_fakultas, $nama_fakultas]);
            return true;
        }catch(Exception $e){
            error_log("Error tambah fakultas: ". $e->getMessage());
            return false;
        }
    }

    public function getAll(){
        try{
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            error_log("Error getAll fakultas: ". $e->getMessage());
            return [];
        }
    }

    public function ubah($id_fakultas, $kode_fakultas, $nama_fakultas){
        try{
            $sql = "UPDATE {$this->table} SET nama_fakultas = ?, kode_fakultas = ? WHERE id_fakultas = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nama_fakultas, $kode_fakultas, $id_fakultas]);
            return true;
        }catch(Exception $e){
            error_log("Error ubah fakultas: ". $e->getMessage());
            return false;
        }
    }

    public function hapus($id_fakultas){
        try{
            $sql = "DELETE FROM {$this->table} WHERE id_fakultas = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_fakultas]);
            return true;
        }catch(Exception $e){
            error_log("Error hapus fakultas: ". $e->getMessage());
            return false;
        }
    }
}
?>