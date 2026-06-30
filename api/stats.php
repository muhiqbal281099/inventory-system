<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if(!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorized"));
    exit();
}

include_once '../config/database.php';
include_once '../models/Item.php';
include_once '../models/Category.php';

$database = new Database();
$db = $database->getConnection();

if($db == null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed"));
    exit();
}

$item = new Item($db);
$category = new Category($db);

// Get real counts
$totalItems = $item->countAll();
$totalCategories = $category->countAll();

// Get low stock and categoriy distribution
$itemsStmt = $item->read();
$lowStock = 0;
$latestItems = [];
$catDistribution = [];
$lowStockItems = [];

while ($row = $itemsStmt->fetch(PDO::FETCH_ASSOC)) {
    if($row['stok'] < 10) {
        $lowStock++;
        if(count($lowStockItems) < 10) $lowStockItems[] = $row;
    }
    
    // Distribution for chart
    $catName = $row['nama_kategori'] ?? 'Tanpa Kategori';
    if(!isset($catDistribution[$catName])) $catDistribution[$catName] = 0;
    $catDistribution[$catName]++;
    
    if(count($latestItems) < 5) {
        $latestItems[] = $row;
    }
}

echo json_encode(array(
    "total_items" => $totalItems,
    "total_categories" => $totalCategories,
    "low_stock" => $lowStock,
    "low_stock_items" => $lowStockItems,
    "latest_items" => $latestItems,
    "chart_labels" => array_keys($catDistribution),
    "chart_data" => array_values($catDistribution)
));
