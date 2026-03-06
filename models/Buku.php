<?php
// Farid Dhiya Fairuz
// 247006111058
// Kelas B
class Buku
{
    private $conn;
    private $table_name = "buku";

    // Property sesuai kolom tabel
    public $id;
    public $isbn;
    public $judul;
    public $pengarang;
    public $kategori;
    public $tahun_terbit;
    public $stok;
    public $cover_url;
    public $deskripsi;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ — ambil semua data buku
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ SINGLE — ambil satu buku berdasarkan ID
    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute([$this->id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->isbn         = $row['isbn'];
            $this->judul        = $row['judul'];
            $this->pengarang    = $row['pengarang'];
            $this->kategori     = $row['kategori'];
            $this->tahun_terbit = $row['tahun_terbit'];
            $this->stok         = $row['stok'];
            $this->cover_url    = $row['cover_url'];
            $this->deskripsi    = $row['deskripsi'];
            return true;
        }
        return false;
    }

    // CREATE — tambah buku baru
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
                  (isbn, judul, pengarang, kategori, tahun_terbit, stok, cover_url, deskripsi)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([
            $this->isbn,
            $this->judul,
            $this->pengarang,
            $this->kategori,
            $this->tahun_terbit,
            $this->stok,
            $this->cover_url,
            $this->deskripsi
        ])) {
            return true;
        }
        return false;
    }

    // UPDATE — ubah data buku
    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
                  SET isbn=?, judul=?, pengarang=?, kategori=?, tahun_terbit=?, stok=?, cover_url=?, deskripsi=?
                  WHERE id=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([
            $this->isbn,
            $this->judul,
            $this->pengarang,
            $this->kategori,
            $this->tahun_terbit,
            $this->stok,
            $this->cover_url,
            $this->deskripsi,
            $this->id
        ])) {
            return true;
        }
        return false;
    }

    // DELETE — hapus buku
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt  = $this->conn->prepare($query);
        if ($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }

    // SEARCH — cari buku berdasarkan keyword
    public function search($keyword)
    {
        $query = "SELECT * FROM " . $this->table_name . "
                  WHERE judul LIKE ? OR pengarang LIKE ? OR kategori LIKE ?
                  ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $k    = "%" . $keyword . "%";
        $stmt->execute([$k, $k, $k]);
        return $stmt;
    }
}
