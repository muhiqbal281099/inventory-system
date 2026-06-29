<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../controllers/ItemController.php';

$database = new Database();
$db = $database->getConnection();

$controller = new ItemController($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $search = isset($_GET['search']) ? $_GET['search'] : "";
        $category = isset($_GET['category']) ? $_GET['category'] : "";
        
        $items = $controller->getAll($search, $category);
        http_response_code(200);
        echo json_encode($items);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if($controller->create($data)) {
            http_response_code(201);
            echo json_encode(array("message" => "Item was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create item."));
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if($controller->update($data)) {
            http_response_code(200);
            echo json_encode(array("message" => "Item was updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update item."));
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $id = isset($_GET['id']) ? $_GET['id'] : (isset($data->id) ? $data->id : null);
        
        if($controller->delete($id)) {
            http_response_code(200);
            echo json_encode(array("message" => "Item was deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete item."));
        }
        break;
}

?>
