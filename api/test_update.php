<?php
// Test update
include_once 'config/database.php';
include_once 'controllers/ItemController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ItemController($db);

$data = new stdClass();
$data->id = 1;
$data->kode_barang = "TEST01";
$data->nama_barang = "Test Update";
$data->kategori_id = 1;
$data->warehouse_id = 1;
$data->stok = 1500;
$data->tanggal_masuk = "2026-06-30";

var_dump($controller->update($data));

$items = $controller->getAll("", "");
var_dump($items[0]);
?>
