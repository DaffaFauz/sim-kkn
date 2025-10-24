<?php
class Kelompok{
    private $pdo;
    private $table = 'kelompok';

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getAll(){
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} INNER JOIN lokasi ON {$this->table}.id_lokasi = lokasi.id_lokasi INNER JOIN tahun_akademik ON {$this->table}.id_tahun = tahun_akademik.id_tahun");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ubah($id_kelompok, $nama_kelompok){
        try{
            $stmt = $this->pdo->prepare("UPDATE {$this->table} SET nama_kelompok = ? WHERE id_kelompok = ?");
            $stmt->execute([$nama_kelompok, $id_kelompok]);
        }catch(PDOException $e){
            throw new Exception("Error updating kelompok: " . $e->getMessage());
        }
    }

    public function hapus($id_kelompok){
        try{
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id_kelompok = ?");
            $stmt->execute([$id_kelompok]);
        }catch(PDOException $e){
            throw new Exception("Error deleting kelompok: " . $e->getMessage());
        }
    }
}
?>