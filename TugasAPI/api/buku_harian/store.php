<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
if ($_SERVER['REQUEST_METHOD'] == "OPTIONS"){
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include('helper.php');
include("../../connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_data = json_decode(file_get_contents("php://input"), true);

    if ($form_data) {
        if (!empty($form_data['judul']) && !empty($form_data['isi']) && !empty($form_data['tanggal'])) {
            
            $judul    = $connect->real_escape_string($form_data['judul']);
            $isi      = $connect->real_escape_string($form_data['isi']);
            $tanggal  = $connect->real_escape_string($form_data['tanggal']);
            $kategori = $connect->real_escape_string($form_data['kategori'] ?? '');

            $store = $connect->query("INSERT INTO diary (judul, isi, tanggal, kategori) 
                                      VALUES ('$judul', '$isi', '$tanggal', '$kategori')");

            if ($store) {
                echo json_encode(response_json(200, "Catatan berhasil ditambahkan."));
            } else {
                echo json_encode(response_json(500, "Gagal menambah catatan: " . $connect->error));
            }

        } else {
            echo json_encode(response_json(400, "Gagal, data tidak lengkap."));
        }
    } else {
        echo json_encode(response_json(400, "Gagal, data tidak boleh kosong."));
    }
} else {
    echo json_encode(response_json(405, "Metode tidak diizinkan."));
}
