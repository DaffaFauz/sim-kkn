<?php
class User{
    private $pdo;
    private $table = 'user';
    
    public function __construct($db){
        $this->pdo = $db;
    }

    public function login($username, $password){
        try{
            // Mendapatkan data user dari database
            $query = "SELECT * FROM {$this->table} WHERE username = ? AND status = 'Aktif'";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Cek ketersediaan data & matching password
            if($user && password_verify($hash, $user['password'])){
                return $user;
            }
            return false;
        } catch (PDOException $e){
            error_log("Error login: ". $e->getMessage());
            return false;
        }
    }
}
?>