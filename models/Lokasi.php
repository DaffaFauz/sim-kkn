<?php
class Lokasi{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function tambah($nama_desa, $nama_kecamatan, $nama_kabupaten){
        try{
            $sql = "INSERT INTO lokasi (nama_desa, nama_kecamatan, nama_kabupaten, status) VALUES (?, ?, ?, 'Tersedia')";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nama_desa, $nama_kecamatan, $nama_kabupaten]);
            return true;
        } catch(Exception $e){
            error_log("Error tambah lokasi: ". $e->getMessage());
            return false;
        }
    }

    public function edit($id_lokasi, $nama_desa, $nama_kecamatan, $nama_kabupaten){
        try{
            $sql = "UPDATE lokasi SET nama_desa = ?, nama_kecamatan = ?, nama_kabupaten = ? WHERE id_lokasi = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nama_desa, $nama_kecamatan, $nama_kabupaten, $id_lokasi]);
            return true;
        } catch(Exception $e){
            error_log("Error edit lokasi: ". $e->getMessage());
            return false;
        }
    }

    public function hapus($id_lokasi){
        try{
            $sql = "DELETE FROM lokasi WHERE id_lokasi = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id_lokasi]);
            return true;
        } catch(Exception $e){
            error_log("Error hapus lokasi: ". $e->getMessage());
            return false;
        }
    }

    public function getAll(){
        try{
            $sql = "SELECT * FROM lokasi";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e){
            error_log("Error get all lokasi: ". $e->getMessage());
            return false;
        }
    }

    public function filter($nama_kecamatan, $nama_kabupaten){
        try{
            $sql = "SELECT * FROM lokasi WHERE 1=1";
            $params = [];

            if(!empty($nama_kecamatan)){
                $sql .= " AND nama_kecamatan = ?";
                $params[] = $nama_kecamatan;
            }

            if(!empty($nama_kabupaten)){
                $sql .= " AND nama_kabupaten = ?";
                $params[] = $nama_kabupaten;
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $e){
            error_log("Error filter lokasi: ". $e->getMessage());
            return false;
        }
    }
}
?>