<?php
session_start();
if(!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

// Tentukan root berdasarkan role
$role = strtolower($_SESSION['role'] ?? 'staff');
$role_folder = 'staff';
if(strpos($role, 'admin') !== false) $role_folder = 'admin';
else if(strpos($role, 'manager') !== false) $role_folder = 'manager';

// Tentukan halaman yang akan diakses
$page = $_GET['p'] ?? 'dashboard';
$allowed = ['dashboard','items','categories','stores','warehouses','transfer','history','restock'];

if (!in_array($page, $allowed)) {
    $page = 'dashboard';
}

$target_file = "views/$role_folder/$page.php";

if (file_exists($target_file)) {
    include $target_file;
} else {
    echo "<h1>Halaman $page tidak tersedia untuk role ini.</h1>";
}
?>