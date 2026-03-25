<?php
session_start();
require 'connect.php';
// Check if user is logged in
if (!isset($_SESSION['email']) || $_SESSION['password'] !== true) {
    // Redirect user to login page if not logged in
    header('Location: login.html');
    exit;
}

// Add to cart logic here
?>