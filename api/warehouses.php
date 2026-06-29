<?php
header("Content-Type: application/json");
include_once '../config/database.php';
include_once '../models/Warehouse.php';

$database = new Database();
$db = $database->getConnection();
$warehouse = new Warehouse($db);

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"));

switch($method) {
    case 'GET':
        $stmt = $warehouse->read();
        $rows = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { $rows[] = $row; }
        echo json_encode($rows);
        break;
    case 'POST':
        $warehouse->nama_gudang = $data->nama_gudang;
        $warehouse->alamat = $data->alamat;
        $warehouse->telepon = $data->telepon;
        if($warehouse->create()) echo json_encode(["message" => "Gudang ditambahkan"]);
        break;
    case 'PUT':
        $warehouse->id = $data->id;
        $warehouse->nama_gudang = $data->nama_gudang;
        $warehouse->alamat = $data->alamat;
        $warehouse->telepon = $data->telepon;
        if($warehouse->update()) echo json_encode(["message" => "Gudang diupdate"]);
        break;
}
