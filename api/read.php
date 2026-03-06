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
include_once '../models/Buku.php';

$database = new Database();
$db       = $database->getConnection();
$buku     = new Buku($db);

// Cek apakah ada parameter search
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $stmt = $buku->search($_GET['search']);
} else {
    $stmt = $buku->read();
}

$num = $stmt->rowCount();

if ($num > 0) {
    $buku_arr = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $buku_arr[] = [
            "id"           => $row['id'],
            "isbn"         => $row['isbn'],
            "judul"        => $row['judul'],
            "pengarang"    => $row['pengarang'],
            "kategori"     => $row['kategori'],
            "tahun_terbit" => $row['tahun_terbit'],
            "stok"         => $row['stok'],
            "cover_url"    => $row['cover_url'],
            "deskripsi"    => $row['deskripsi']
        ];
    }
    http_response_code(200);
    echo json_encode($buku_arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Data buku tidak ditemukan."]);
}
?>
