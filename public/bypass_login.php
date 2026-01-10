<?php
session_start();
$_SESSION['is_logged_in'] = true;
$_SESSION['role'] = 'Admin';
$_SESSION['user_id'] = 16; // Admin ID from SQL
header('Location: /admin/dashboard');
exit;
