<?php
class Mahasiswa
{
    private $pdo;
    private $table = 'mahasiswa';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($data){
        $this->pdo->beginTransaction();
         // Create account after before mahasiswa
            $accountSql = "INSERT INTO user (username, password) VALUES (?, ?)";
            $accountStmt = $this->pdo->prepare($accountSql);
            $hashedPassword = password_hash($data['nim'], PASSWORD_BCRYPT);
            $accountStmt->execute([$data['nim'], $hashedPassword]);

        // Execute the statement
        if($accountStmt->execute()){
           // Create mahasiswa record
           $id_account = $this->pdo->lastInsertId();
            $sql = "INSERT INTO " . $this->table . " (id_user, nim, nama_mahasiswa, alamat, jenis_kelamin, id_prodi, kelas, id_jabatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);

            // Execute the statement with the provided data
            $stmt->execute([
                $id_account,
                $data['nim'],
                $data['nama'],
                $data['alamat'],
                $data['jenis_kelamin'],
                $data['id_prodi'],
                $data['kelas'],
                5
            ]);

            // Commit the transaction
            $this->pdo->commit();
            return true;
        }
        return false;
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
