<?php
class Dashboard {
    private $pdo;

    public function _construct($db) {
        $this->pdo = $db;
    }

    // Admin
    public function getAdminData() {
        $data = [];
        $data['jumlah_mahasiswa'] = $this->pdo->query("SELECT COUNT(*) FROM mahasiswa")->fetchColumn();
        $data['jumlah_pembimbing'] = $this->pdo->query("SELECT COUNT(*), user.role  FROM dosen INNER JOIN user ON dosen.id_user = user.id_user WHERE user.role = 'Pembimbing' GROUP BY user.role")->fetchColumn();
        $data['jumlah_kelompok'] = $this->pdo->query("SELECT COUNT(*) FROM kelompok")->fetchColumn();
        $data['jumlah_lokasi'] = $this->pdo->query("SELECT COUNT(*) FROM lokasi")->fetchColumn();
        $data['laporan_kegiatan'] = $this->pdo->query("SELECT * FROM laporan_harian ORDER BY tanggal DESC LIMIT 10")->fetchColumn();

        return $data;
    }
        
    // Kaprodi
    public function getKaprodiData($id_user){
        $sql = "SELECT m.*, p.nama_prodi FROM mahasiswa m INNER JOIN prodi p ON m.id_prodi = p.id_prodi WHERE m.status_pembayaran = 'Pending'";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pembimbing
    public function getPembimbingData($id_user){
        $data = [];

        // Data kelompok yang dibimbing
        $data['kelompok'] = $this->pdo->prepare("SELECT k.* FROM kelompok k INNER JOIN pembimbing_kelompok pk ON k.id_pembimbing = pk.id_dosen WHERE pk.id_dosen = ?")->execute([$id_user]);
        $data['kelompok']->execute([$id_user]);
        $data['kelompok'] = $data['kelompok']->fetchAll(PDO::FETCH_ASSOC);

        // Laporan Harian Kelompok
        $data['laporan_harian'] = $this->pdo->prepare("SELECT lh.*, m.nama_mahasiswa, k.nama_kelompok FROM laporan_harian lh INNER JOIN  kelompok k ON lh.id_kelompok = k.id_kelompok WHERE k.id_pembimbing = ?");
        $data['laporan_harian']->execute([$id_user]);
        $data['laporan_harian'] = $data['laporan_harian']->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    // Mahasiswa
    public function getMahasiswaData($id_user){
        $data = [];

        // Status Verifikasi
        $data['status'] = $this->pdo->prepare("SELECT status_verifikasi FROM mahasiswa WHERE id_user = ?");
        $data['status']->execute([$id_user]);
        $data['status'] = $data['status']->fetchColumn();

        if($data['status'] === 'Pending' || $data['status'] === 'Diverifikasi Kaprodi'){
            $data['status'] === 'Pending';
        }

        // Laporan Kegiatan Harian Kelompok
        $data['laporan_harian'] = $this->pdo->prepare("SELECT * FROM laporan_harian INNER JOIN kelompok ON laporan_harian.id_kelompok = kelompok.id_kelompok INNER JOIN anggota_kelompok ON kelompok.id_kelompok = anggota_kelompok.id_kelompok INNER JOIN mahasiswa ON anggota_kelompok.id_mahasiswa = mahasiswa.id_mahasiswa WHERE mahasiswa.id_user = ? ORDER BY tanggal DESC LIMIT 10");
        $data['laporan_harian']->execute([$id_user]);
        $data['laporan_harian'] = $data['laporan_harian']->fetchAll(PDO::FETCH_ASSOC);

        // Data Kelompok Mahasiswa
        $data['kelompok'] = $this->pdo->prepare("SELECT k.* FROM kelompok k INNER JOIN anggota_kelompok ak ON k.id_kelompok = ak.id_kelompok INNER JOIN mahasiswa m ON ak.id_mahasiswa = m.id_mahasiswa WHERE m.id_user = ?");
        $data['kelompok']->execute([$id_user]);

        return $data;
    }
}
?>