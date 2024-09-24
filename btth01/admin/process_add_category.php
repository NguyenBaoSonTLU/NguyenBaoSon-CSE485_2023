<?php
include '../Connect/db.php'; // Kết nối CSDL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem tên thể loại có được gửi không
    if (isset($_POST['ten_tloai'])) {
        $ten_tloai = $_POST['ten_tloai'];

        // Thực hiện truy vấn để thêm thể loại
        $sql = "INSERT INTO theloai (ten_tloai) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ten_tloai);

        if ($stmt->execute()) {
            header("Location: category.php"); // Chuyển hướng về danh sách thể loại
            exit;
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } else {
        echo "Tên thể loại không được gửi.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
