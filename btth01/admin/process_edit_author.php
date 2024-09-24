<?php
include '../Connect/db.php'; // Kết nối CSDL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['txtCatId']) && isset($_POST['txtCatName'])) {
        $ma_tgia = $_POST['txtCatId'];
        $ten_tgia = $_POST['txtCatName'];

        // Cập nhật thông tin thể loại
        $update_sql = "UPDATE tacgia SET ten_tgia = ? WHERE ma_tgia = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $ten_tgia, $ma_tgia);

        if ($update_stmt->execute()) {
            header("Location: author.php"); // Chuyển hướng về danh sách thể loại
            exit;
        } else {
            echo "Lỗi: " . $update_stmt->error;
        }
    } else {
        echo "Dữ liệu không hợp lệ.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
