<?php
session_start();
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$role = strtolower($_SESSION['role'] ?? 'staff');
if(strpos($role, 'admin') !== false) include 'views/admin/stores.php';
else if(strpos($role, 'manager') !== false) include 'views/manager/stores.php';
else include 'views/staff/stores.php';
?>