<?php
class Dosen {
    private $pdo;
    private $table = "dosen";

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAllDosen() {
        $stmt = $this->pdo->query("SELECT d.*, u.status as status_akun, u.role 
                                   FROM dosen d 
                                   LEFT JOIN user u ON d.id_user = u.id_user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahDosen($nama, $jabatan) {
        // Insert dosen baru
        $stmt = $this->pdo->prepare("INSERT INTO dosen (nama_dosen, jabatan) VALUES (?, ?)");
        $stmt->execute([$nama, $jabatan]);

        // Jika jabatan istimewa → buat akun otomatis
        if ($jabatan === 'Kaprodi' || $jabatan === 'Pembimbing') {
            $id_dosen = $this->pdo->lastInsertId();
            $this->buatAkunDosen($id_dosen, $jabatan);
        }

        return true;
    }

    public function ubahJabatan($id_dosen, $jabatanBaru) {
        $stmt = $this->pdo->prepare("SELECT * FROM dosen WHERE id_dosen = ?");
        $stmt->execute([$id_dosen]);
        $dosen = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dosen) return false;

        $jabatanLama = $dosen['jabatan'];
        $id_user = $dosen['id_user'];

        // Jika dicopot jadi dosen biasa
        if ($jabatanBaru === 'Dosen') {
            $this->pdo->prepare("UPDATE dosen SET jabatan = 'Dosen' WHERE id_dosen = ?")
                      ->execute([$id_dosen]);
            if ($id_user) {
                $this->pdo->prepare("UPDATE user SET status = 'nonaktif' WHERE id_user = ?")
                          ->execute([$id_user]);
            }
            return true;
        }

        // Jika belum punya akun → buat
        if (!$id_user && ($jabatanBaru === 'Kaprodi' || $jabatanBaru === 'Pembimbing')) {
            $this->buatAkunDosen($id_dosen, $jabatanBaru);
        } else {
            // Jika sudah punya akun, update jabatan dan aktifkan
            $jabatanList = explode(',', $jabatanLama);
            if (!in_array($jabatanBaru, $jabatanList)) {
                $jabatanList[] = $jabatanBaru;
            }
            $newJabatan = implode(',', array_unique($jabatanList));

            $this->pdo->prepare("UPDATE dosen SET jabatan = ? WHERE id_dosen = ?")
                      ->execute([$newJabatan, $id_dosen]);
            $this->pdo->prepare("UPDATE user SET status = 'aktif' WHERE id_user = ?")
                      ->execute([$id_user]);
        }
        return true;
    }

    private function buatAkunDosen($id_dosen, $role) {
        // Ambil nama dosen
        $stmt = $this->pdo->prepare("SELECT nama_dosen FROM dosen WHERE id_dosen = ?");
        $stmt->execute([$id_dosen]);
        $dosen = $stmt->fetch(PDO::FETCH_ASSOC);

        $username = strtolower(str_replace(' ', '', $dosen['nama_dosen']));
        $password = password_hash('123456', PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO user (username, password, role, status) VALUES (?, ?, ?, 'aktif')");
        $stmt->execute([$username, $password, $role]);
        $id_user = $this->pdo->lastInsertId();

        // Update id_user di tabel dosen
        $this->pdo->prepare("UPDATE dosen SET id_user = ? WHERE id_dosen = ?")
                  ->execute([$id_user, $id_dosen]);
    }
}
