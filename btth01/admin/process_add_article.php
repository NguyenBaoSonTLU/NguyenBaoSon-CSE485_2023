<?php
// Kết nối CSDL từ file db.php
include '../Connect/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem các trường dữ liệu có được gửi không
    if (isset($_POST['ten_tieu_de'], $_POST['tom_tat'], $_POST['ten_bhat'], $_POST['ma_tloai'], $_POST['ma_tgia'], $_POST['noidung'])) {
        // Nhận giá trị từ form
        $ten_tieu_de = $_POST['ten_tieu_de'];
        $tom_tat = $_POST['tom_tat'];
        $ten_bhat = $_POST['ten_bhat'];
        $ma_tloai = $_POST['ma_tloai'];
        $ma_tgia = $_POST['ma_tgia'];
        $noidung = $_POST['noidung'];
        $ngayviet = date('Y-m-d'); // Lấy ngày hiện tại
        
        // Truy vấn thêm bài viết với tất cả các cột tương ứng
        $sql = "INSERT INTO baiviet (tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // Chuẩn bị câu truy vấn
        $stmt = $conn->prepare($sql);
        
        // Gán giá trị cho các tham số trong truy vấn
        $stmt->bind_param("ssissss", $ten_tieu_de, $ten_bhat, $ma_tloai, $tom_tat, $noidung, $ma_tgia, $ngayviet);

        // Thực thi truy vấn
        if ($stmt->execute()) {
            // Chuyển hướng về trang danh sách bài viết sau khi thêm thành công
            header("Location: article.php");
            exit;
        } else {
            // Thông báo lỗi nếu có vấn đề khi thêm dữ liệu
            echo "Lỗi: " . $stmt->error;
        }
    } else {
        // Thông báo nếu dữ liệu không đầy đủ
        echo "Dữ liệu không hợp lệ.";
    }
} else {
    // Thông báo nếu yêu cầu không phải là POST
    echo "Yêu cầu không hợp lệ.";
}
?>
