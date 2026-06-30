<?php
session_start();
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$role = strtolower($_SESSION['role'] ?? 'staff');
if(strpos($role, 'admin') !== false) include 'views/admin/restock.php';
else if(strpos($role, 'manager') !== false) include 'views/manager/restock.php';
else include 'views/staff/restock.php';
?>
