<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

if($db == null) {
    http_response_code(500);
    echo json_encode(array("message" => "Gagal terhubung ke database. Pastikan MySQL sudah jalan dan database 'inventory_system' sudah dibuat."));
    exit();
}

$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->username) && !empty($data->password)) {
    $user->username = $data->username;
    $user->password = $data->password;

    try {
        if($user->login()) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['nama'] = $user->nama;
            
            http_response_code(200);
            echo json_encode(array(
                "message" => "Login successful.",
                "user" => array(
                    "id" => $user->id,
                    "username" => $user->username,
                    "nama" => $user->nama
                )
            ));
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Login gagal. Username atau password salah."));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Table tidak ditemukan. Pastikan anda sudah mengimpor 'schema.sql'."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Login failed. Incomplete data."));
}
