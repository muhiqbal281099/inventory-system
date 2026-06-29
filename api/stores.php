<?php
header("Content-Type: application/json");
include_once '../config/database.php';
include_once '../models/Store.php';

$database = new Database();
$db = $database->getConnection();
$store = new Store($db);

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"));

switch($method) {
    case 'GET':
        $stmt = $store->read();
        $rows = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { $rows[] = $row; }
        echo json_encode($rows);
        break;
    case 'POST':
        $store->nama_toko = $data->nama_toko;
        $store->alamat = $data->alamat;
        $store->telepon = $data->telepon;
        if($store->create()) echo json_encode(["message" => "Toko ditambahkan"]);
        break;
    case 'PUT':
        $store->id = $data->id;
        $store->nama_toko = $data->nama_toko;
        $store->alamat = $data->alamat;
        $store->telepon = $data->telepon;
        if($store->update()) echo json_encode(["message" => "Toko diupdate"]);
        break;
}
