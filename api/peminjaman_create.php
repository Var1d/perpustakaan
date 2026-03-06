<?php
// Farid Dhiya Fairuz
// 247006111058
// Kelas B
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

include_once '../config/Database.php';
include_once '../models/Peminjaman.php';

$database   = new Database();
$db         = $database->getConnection();
$peminjaman = new Peminjaman($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nama_peminjam) && !empty($data->buku_id) && !empty($data->tanggal_pinjam) && !empty($data->tanggal_kembali)) {
    $peminjaman->nama_peminjam   = $data->nama_peminjam;
    $peminjaman->buku_id         = $data->buku_id;
    $peminjaman->tanggal_pinjam  = $data->tanggal_pinjam;
    $peminjaman->tanggal_kembali = $data->tanggal_kembali;

    if ($peminjaman->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Buku berhasil dipinjam."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Gagal meminjam buku. Kemungkinan stok habis."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Data tidak lengkap."]);
}
?>
