<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

$data = json_decode('{"id":1,"kode_barang":"BRG01","nama_barang":"Laptop Updated","kategori_id":"1","warehouse_id":"1","stok":"50","tanggal_masuk":"2023-10-01"}');

include_once 'controllers/ItemController.php';
$controller = new ItemController($db);
var_dump($controller->update($data));

$stmt = $db->query("SELECT * FROM items WHERE id = 1");
print_r($stmt->fetch(PDO::FETCH_ASSOC));
?>
