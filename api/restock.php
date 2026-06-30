<?php
header("Content-Type: application/json");
include_once '../config/database.php';
include_once '../models/StockMovement.php';

$database = new Database();
$db = $database->getConnection();
$movement = new StockMovement($db);

$data = json_decode(file_get_contents("php://input"));

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($data->item_id) && !empty($data->qty)) {
        $movement->item_id = $data->item_id;
        $movement->store_id = null; // No store since it's going into central warehouse
        $movement->qty = $data->qty;
        $movement->type = 'IN';
        $movement->keterangan = $data->keterangan;
        $movement->status = 'APPROVED'; // Stock IN operates directly right now (can also be made PENDING if desired)

        if($movement->create()) {
            http_response_code(200);
            echo json_encode(["message" => "Stok berhasil ditambahkan"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Gagal menambahkan stok"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Data tidak lengkap"]);
    }
}
?>
