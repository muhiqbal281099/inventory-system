<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'config/database.php';
include_once 'controllers/ItemController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ItemController($db);

$items = $controller->getAll();
print_r($items);
