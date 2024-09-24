<?php
// Kết nối CSDL từ file db.php
include '../Connect/db.php';

if (isset($_GET['ma_bviet'])) {
    // Nhận ma_bviet của bài viết cần xóa
    $ma_bviet = intval($_GET['ma_bviet']); // Chuyển đổi thành số nguyên

    // Kiểm tra xem ma_bviet có hợp lệ không
    if ($ma_bviet > 0) {
        // Câu lệnh xóa
        $sql = "DELETE FROM baiviet WHERE ma_bviet = ?";
        
        // Chuẩn bị câu truy vấn
        if ($stmt = $conn->prepare($sql)) {
            // Gán giá trị cho tham số trong truy vấn
            $stmt->bind_param("i", $ma_bviet);

            // Thực thi truy vấn
            if ($stmt->execute()) {
                // Chuyển hướng về trang danh sách bài viết sau khi xóa thành công
                header("Location: article.php");
                exit;
            } else {
                // Thông báo lỗi nếu có vấn đề khi xóa dữ liệu
                echo "Lỗi: " . $stmt->error;
            }
            $stmt->close(); // Đóng statement
        } else {
            echo "Lỗi khi chuẩn bị câu truy vấn: " . $conn->error;
        }
    } else {
        echo "ID bài viết không hợp lệ.";
    }
} else {
    // Thông báo nếu không có ma_bviet hoặc yêu cầu không hợp lệ
    echo "Yêu cầu không hợp lệ.";
}

// Đóng kết nối
$conn->close();
?>
