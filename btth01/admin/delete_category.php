<?php
include '../Connect/db.php'; // Kết nối CSDL

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Xóa tất cả các bài viết liên quan đến thể loại
    $delete_articles_sql = "DELETE FROM baiviet WHERE ma_tloai = ?";
    $stmt = $conn->prepare($delete_articles_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Sau đó, xóa thể loại 
    $delete_category_sql = "DELETE FROM theloai WHERE ma_tloai = ?";
    $stmt = $conn->prepare($delete_category_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: category.php"); // Chuyển hướng về danh sách thể loại
    exit;
} else {
    echo "ID không hợp lệ.";
    exit;
}
?>
