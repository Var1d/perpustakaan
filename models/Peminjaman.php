<?php
// Farid Dhiya Fairuz
// 247006111058
// Kelas B
class Peminjaman
{
    private $conn;
    private $table_name = "peminjaman";

    public $id;
    public $nama_peminjam;
    public $buku_id;
    public $tanggal_pinjam;
    public $tanggal_kembali;
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ — ambil semua data peminjaman beserta judul buku
    public function read()
    {
        $query = "SELECT p.*, b.judul, b.pengarang, b.cover_url
                  FROM " . $this->table_name . " p
                  JOIN buku b ON p.buku_id = b.id
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // CREATE — tambah peminjaman baru
    public function create()
    {
        // Cek stok dulu
        $cek = $this->conn->prepare("SELECT stok FROM buku WHERE id = ?");
        $cek->execute([$this->buku_id]);
        $buku = $cek->fetch(PDO::FETCH_ASSOC);
        if (!$buku || $buku['stok'] < 1) {
            return false;
        }

        // Insert peminjaman
        $query = "INSERT INTO " . $this->table_name . "
                  (nama_peminjam, buku_id, tanggal_pinjam, tanggal_kembali, status)
                  VALUES (?, ?, ?, ?, 'dipinjam')";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([
            $this->nama_peminjam,
            $this->buku_id,
            $this->tanggal_pinjam,
            $this->tanggal_kembali
        ])) {
            // Kurangi stok buku
            $upd = $this->conn->prepare("UPDATE buku SET stok = stok - 1 WHERE id = ?");
            $upd->execute([$this->buku_id]);
            return true;
        }
        return false;
    }

    // UPDATE status — kembalikan buku
    public function kembalikan()
    {
        // Ambil buku_id dulu
        $cek = $this->conn->prepare("SELECT buku_id FROM " . $this->table_name . " WHERE id = ?");
        $cek->execute([$this->id]);
        $row = $cek->fetch(PDO::FETCH_ASSOC);
        if (!$row) return false;

        $query = "UPDATE " . $this->table_name . " SET status = 'dikembalikan' WHERE id = ?";
        $stmt  = $this->conn->prepare($query);
        if ($stmt->execute([$this->id])) {
            // Tambah stok buku kembali
            $upd = $this->conn->prepare("UPDATE buku SET stok = stok + 1 WHERE id = ?");
            $upd->execute([$row['buku_id']]);
            return true;
        }
        return false;
    }

    // DELETE — hapus data peminjaman
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt  = $this->conn->prepare($query);
        if ($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
}
