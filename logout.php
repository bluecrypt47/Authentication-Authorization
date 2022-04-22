<?php session_start();

if (isset($_SESSION['email'])) {
    unset($_SESSION['email']); // xóa session login
    echo '<script> window.location="login.php";</script>';
}
