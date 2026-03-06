<?php
// Farid Dhiya Fairuz
// 247006111058
// Kelas B
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

include_once '../config/Database.php';
include_once '../models/Peminjaman.php';

$database   = new Database();
$db         = $database->getConnection();
$peminjaman = new Peminjaman($db);
$stmt       = $peminjaman->read();
$num        = $stmt->rowCount();

if ($num > 0) {
    $arr = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $arr[] = [
            "id"              => $row['id'],
            "nama_peminjam"   => $row['nama_peminjam'],
            "buku_id"         => $row['buku_id'],
            "judul"           => $row['judul'],
            "pengarang"       => $row['pengarang'],
            "cover_url"       => $row['cover_url'],
            "tanggal_pinjam"  => $row['tanggal_pinjam'],
            "tanggal_kembali" => $row['tanggal_kembali'],
            "status"          => $row['status']
        ];
    }
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Belum ada data peminjaman."]);
}
?>
