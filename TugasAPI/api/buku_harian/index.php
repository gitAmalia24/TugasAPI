<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
if ($_SERVER['REQUEST_METHOD'] == "OPTIONS"){
    http_response_code(200);
    exit();
}
include('helper.php');  

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include("../../connect.php");

    // ambil semua data dari tabel buku_harian
    $read = $connect->query("SELECT * FROM diary");
    $result = $read->fetch_all(MYSQLI_ASSOC);

    $array_api = response_json(200, 'berhasil mengambil data buku harian', $result);
} 
else {
    $array_api = response_json(405, 'metode tidak diizinkan.');
} 

echo json_encode($array_api);

?>
