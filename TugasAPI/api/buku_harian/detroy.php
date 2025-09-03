<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include('helper.php');
include("../../connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $id = $_GET['id'];

        // cari id di tabel buku_harian
        $search_id = $connect->query("SELECT * FROM diary WHERE id='$id'");
        $diary = $search_id->fetch_assoc();

        if ($diary != NULL) {
            // hapus jika ditemukan
            $delete = $connect->query("DELETE FROM diary WHERE id='$id'");
            
            if ($delete) {
                $array_api = response_json(200, 'Berhasil menghapus data buku harian');
            } else {
                $array_api = response_json(500, 'Gagal menghapus data buku harian: ' . $connect->error);
            }
        } else {
            $array_api = response_json(404, 'Gagal menghapus data buku harian, data tidak ditemukan.');
        }
    } else {
        $array_api = response_json(400, 'Gagal menghapus data buku harian, id tidak boleh kosong.');
    }
} else {
    $array_api = response_json(405, 'Metode tidak diizinkan.');
}

echo json_encode($array_api);
?>
