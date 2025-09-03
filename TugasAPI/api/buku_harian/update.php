<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS"){
    http_response_code(200);
    exit();
}

include('helper.php');

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    include("../../connect.php");

    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        // cek data ada atau tidak
        $search_id = $connect->query("SELECT * FROM diary WHERE id='$id'");
        $data = $search_id->fetch_assoc();

        if ($data) {
            $form_data = json_decode(file_get_contents("php://input"));

            if (!empty($form_data->judul) && !empty($form_data->isi) && !empty($form_data->tanggal) && !empty($form_data->kategori)) {

                $judul    = $form_data->judul;
                $isi      = $form_data->isi;
                $tanggal  = $form_data->tanggal;
                $kategori = $form_data->kategori;

                // pakai prepared statement (lebih aman dari SQL Injection)
                $stmt = $connect->prepare("UPDATE diary 
                                           SET judul=?, isi=?, tanggal=?, kategori=? 
                                           WHERE id=?");
                $stmt->bind_param("ssssi", $judul, $isi, $tanggal, $kategori, $id);
                $update = $stmt->execute();

                if ($update) {
                    $array_api = response_json(200, 'berhasil mengupdate data buku harian');
                } else {
                    $array_api = response_json(500, 'gagal mengupdate data buku harian (query error)');
                }
            } else {
                $array_api = response_json(400, 'gagal mengupdate data buku harian, formulir tidak lengkap.');
            }
        } else {
            $array_api = response_json(404, 'gagal mengupdate data buku harian, data tidak ditemukan.');
        }
    } else {
        $array_api = response_json(400, 'gagal mengupdate data buku harian, id tidak boleh kosong.');
    }
} else {
    $array_api = response_json(405, 'metode tidak diizinkan.');
}

echo json_encode($array_api);
?>


