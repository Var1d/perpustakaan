<?php
// Farid Dhiya Fairuz
// 247006111058
// Kelas B
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
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

if (empty($data->id)) {
    http_response_code(400);
    echo json_encode(["message" => "ID peminjaman wajib disertakan."]);
    exit;
}

$peminjaman->id = $data->id;

if ($peminjaman->kembalikan()) {
    http_response_code(200);
    echo json_encode(["message" => "Buku berhasil dikembalikan. Stok telah diperbarui."]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Gagal mengembalikan buku."]);
}
?>
