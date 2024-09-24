<?php
$host = '127.0.0.1';
$user = 'root';
$password = ''; // Thêm mật khẩu của bạn nếu có
$database = 'btth01_cse485'; 

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>
