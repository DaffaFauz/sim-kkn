<?php
class Prodi{
    private $pdo;
    private $table = 'prodi';

    public function __construct($pdo){
        $this->pdo = $pdo;
    }


    public function getAll(){
        try {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} INNER JOIN fakultas ON prodi.id_fakultas = fakultas.id_fakultas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
        error_log("Error get all prodi: ". $e->getMessage());
        return [];
        }    
    }

    public function filter($id_fakultas){
        try{
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} LEFT JOIN fakultas ON prodi.id_fakultas = fakultas.id_fakultas WHERE nama_fakultas = ?");
        $stmt->execute([$id_fakultas]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
        error_log("Error filter prodi: ". $e->getMessage());
        return false;
        }
    }

    public function tambah($kode_prodi, $nama_prodi, $fakultas_id){
        try {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (kode_prodi, nama_prodi, id_fakultas) VALUES (?, ?, ?)");
        $stmt->execute([$kode_prodi, $nama_prodi, $fakultas_id]);
        return true;
        } catch (Exception $e) {
        error_log("Error tambah prodi: ". $e->getMessage());
        return false;
        }
    }

    public function ubah($id_prodi, $kode_prodi, $nama_prodi, $id_fakultas){
        try {
        $stmt = $this->pdo->prepare("UPDATE " . $this->table . " SET kode_prodi = ?, nama_prodi = ?, id_fakultas = ? WHERE id_prodi = ?");
        return $stmt->execute([$kode_prodi, $nama_prodi, $id_fakultas, $id_prodi]);
        } catch (Exception $e) {
        error_log("Error ubah prodi: ". $e->getMessage());
        return false;
        }
    }

    public function hapus($id_prodi){
        try {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id_prodi = ?");
        return $stmt->execute([$id_prodi]);
        } catch (Exception $e) {
        error_log("Error hapus prodi: ". $e->getMessage());
        return false;
        }
    }

    public function DaftarProdiByFakultas($fakultas){
        try{
            $sql = "SELECT * FROM prodi WHERE id_fakultas = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$fakultas]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e){
            error_log("Error daftar prodi by fakultas: ". $e->getMessage());
            return false;
        }
    }
}
?>
