<?php
// Kết nối CSDL từ file db.php
include '../Connect/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ form
    $ma_bviet = intval($_POST['ma_bviet']);
    $tieude = $_POST['tieude'];
    $ten_bai_hat = $_POST['ten_bhat'];
    $tomtat = $_POST['tomtat'];
    $noidung = $_POST['noidung'];
    $ma_tloai = $_POST['ma_tloai'];
    $ma_tgia = $_POST['ma_tgia'];
    $new_tloai = $_POST['new_tloai'] ?? '';
    $new_tgia = $_POST['new_tgia'] ?? '';

    // Nếu có thể loại mới, thêm vào cơ sở dữ liệu
    if (!empty($new_tloai)) {
        $insert_tloai_sql = "INSERT INTO theloai (ten_tloai) VALUES (?)";
        if ($insert_stmt = $conn->prepare($insert_tloai_sql)) {
            $insert_stmt->bind_param("s", $new_tloai);
            $insert_stmt->execute();
            $ma_tloai = $conn->insert_id; // Lấy ma_tloai vừa được thêm
            $insert_stmt->close();
        } else {
            echo "Lỗi thêm thể loại: " . $conn->error;
        }
    }

    // Nếu có tác giả mới, thêm vào cơ sở dữ liệu
    if (!empty($new_tgia)) {
        $insert_tgia_sql = "INSERT INTO tacgia (ten_tgia) VALUES (?)";
        if ($insert_stmt = $conn->prepare($insert_tgia_sql)) {
            $insert_stmt->bind_param("s", $new_tgia);
            $insert_stmt->execute();
            $ma_tgia = $conn->insert_id; // Lấy ma_tgia vừa được thêm
            $insert_stmt->close();
        } else {
            echo "Lỗi thêm tác giả: " . $conn->error;
        }
    }

    // Cập nhật bài viết trong cơ sở dữ liệu
    $update_sql = "UPDATE baiviet SET tieude = ?, ten_bhat = ?, tomtat = ?, noidung = ?, ma_tloai = ?, ma_tgia = ? WHERE ma_bviet = ?";
    if ($update_stmt = $conn->prepare($update_sql)) {
        $update_stmt->bind_param("ssssiii", $tieude, $ten_bai_hat, $tomtat, $noidung, $ma_tloai, $ma_tgia, $ma_bviet);
        if ($update_stmt->execute()) {
            echo "Cập nhật bài viết thành công.";
            // Redirect to the articles page or another page
            header("Location: article.php");
            exit();
        } else {
            echo "Lỗi cập nhật bài viết: " . $conn->error;
        }
        $update_stmt->close();
    } else {
        echo "Lỗi chuẩn bị câu lệnh cập nhật: " . $conn->error;
    }

    // Đóng kết nối
    $conn->close();
} else {
    echo "Yêu cầu không hợp lệ.";
}
