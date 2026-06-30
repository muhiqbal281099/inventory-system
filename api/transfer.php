<?php
header("Content-Type: application/json");
include_once '../config/database.php';
include_once '../models/StockMovement.php';

$database = new Database();
$db = $database->getConnection();
$movement = new StockMovement($db);

$data = json_decode(file_get_contents("php://input"));

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($data->item_id) && !empty($data->store_id) && !empty($data->qty)) {
        $movement->item_id = $data->item_id;
        $movement->store_id = $data->store_id;
        $movement->qty = $data->qty;
        $movement->type = 'TRANSFER';
        $movement->keterangan = "Transfer ke " . ($data->store_name ?? 'toko');
        $movement->status = 'PENDING';

        if($movement->create()) {
            echo json_encode(["message" => "Transfer Berhasil (Menunggu Approval)"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Gagal melakukan transfer"]);
        }
    }
} else if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $action = $data->action ?? '';
    $id = $data->id ?? '';
    if ($action == 'approve' && $movement->approve($id)) {
        echo json_encode(["message" => "Transfer disetujui, stok berhasil diproses."]);
    } else if ($action == 'reject' && $movement->reject($id)) {
        echo json_encode(["message" => "Transfer ditolak."]);
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Gagal memproses approval."]);
    }
} else if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $movement->readAll();
    $history = [];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $history[] = $row;
    }
    echo json_encode($history);
}
