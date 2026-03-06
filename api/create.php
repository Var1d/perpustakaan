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
include_once '../models/Buku.php';

$database = new Database();
$db       = $database->getConnection();
$buku     = new Buku($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->isbn) &&
    !empty($data->judul) &&
    !empty($data->pengarang) &&
    !empty($data->kategori) &&
    !empty($data->tahun_terbit)
) {
    $buku->isbn         = $data->isbn;
    $buku->judul        = $data->judul;
    $buku->pengarang    = $data->pengarang;
    $buku->kategori     = $data->kategori;
    $buku->tahun_terbit = $data->tahun_terbit;
    $buku->stok         = $data->stok ?? 0;
    $buku->cover_url    = $data->cover_url ?? "";
    $buku->deskripsi    = $data->deskripsi ?? "";

    if ($buku->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Buku berhasil ditambahkan."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Gagal menambahkan buku."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Data tidak lengkap. Field isbn, judul, pengarang, kategori, tahun_terbit wajib diisi."]);
}
?>
