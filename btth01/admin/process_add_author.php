<?php
include '../Connect/db.php'; // Kết nối CSDL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem tên thể loại có được gửi không
    if (isset($_POST['ten_tgia'])) {
        $ten_tgia = $_POST['ten_tgia'];

        // Thực hiện truy vấn để thêm thể loại
        $sql = "INSERT INTO tacgia (ten_tgia) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ten_tgia);

        if ($stmt->execute()) {
            header("Location: author.php"); // Chuyển hướng về danh sách thể loại
            exit;
        } else {
            echo "Lỗi: " . $stmt->error;
        }
    } else {
        echo "Tên tác giả không được gửi.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
