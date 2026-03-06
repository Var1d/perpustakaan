<?php
// Farid Dhiya Fairuz
// 247006111058
// Kelas B
class Database {
    private $host     = "localhost";
    private $db_name  = "perpustakaan";
    private $username = "admin_perpus";
    private $password = "perpus123";
    public  $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Koneksi Gagal: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
