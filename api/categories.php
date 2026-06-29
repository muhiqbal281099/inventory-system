<?php
header("Content-Type: application/json");
include_once '../config/database.php';
include_once '../models/Category.php';

$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"));

switch($method) {
    case 'GET':
        $stmt = $category->read();
        $cats = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { $cats[] = $row; }
        echo json_encode($cats);
        break;
    case 'POST':
        $category->nama_kategori = $data->nama_kategori;
        if($category->create()) echo json_encode(["message" => "Kategori ditambahkan"]);
        break;
    case 'PUT':
        $category->id = $data->id;
        $category->nama_kategori = $data->nama_kategori;
        if($category->update()) echo json_encode(["message" => "Kategori diupdate"]);
        break;
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : (isset($data->id) ? $data->id : null);
        $category->id = $id;
        if($category->delete()) {
            echo json_encode(["message" => "Kategori dihapus"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Gagal hapus! Masih ada barang di kategori ini."]);
        }
        break;
}
