<?php include '../Connect/db.php'; // Kết nối CSDL
// Truy vấn lấy danh sách thể loại
$sql = "SELECT ma_tloai, ten_tloai FROM theloai";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Hiển thị thể loại
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ma_tloai'] . "</td>";
        echo "<td>" . $row['ten_tloai'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "Không có thể loại nào.";
} ?>
<?php include '../Connect/db.php'; // Kết nối CSDL

// Truy vấn lấy danh sách thể loại
$sql = "SELECT ma_tgia, ten_tgia FROM tacgia";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Hiển thị thể loại
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ma_tgia'] . "</td>";
        echo "<td>" . $row['ten_tgia'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "Không có thể loại nào.";
} ?>
<?php   
    include '../Connect/db.php';

    $sql = "SELECT ma_bviet, tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet  FROM baiviet";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Hiển thị thể loại
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ma_bviet'] . "</td>";
        echo "<td>" . $row['tieude'] . "</td>";
        echo "<td>" . $row['ten_bhat'] . "</td>";
        echo "<td>" . $row['ma_tloai'] . "</td>";
        echo "<td>" . $row['tomtat'] . "</td>";
        echo "<td>" . $row['noidung'] . "</td>";
        echo "<td>" . $row['ma_tgia'] . "</td>";
        echo "<td>" . $row['ngayviet'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "Không có thể loại nào.";
} 
?>
<?php
include '../btth01/Connect/db.php';

// Lấy dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
    

        // Bảo mật mật khẩu
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Chuẩn bị câu lệnh SQL
        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$hashed_password')";

        // Kiểm tra và thực thi câu lệnh SQL
        if ($conn->query($sql) === TRUE) {
            echo "Đăng ký thành công!";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin.";
    }
}
?>
<div>
    <p>Số lượng thể loại: <?php echo $count_theloai; ?></p>
    <p>Số lượng tác giả: <?php echo $count_tacgia; ?></p>
    <p>Số lượng bài viết: <?php echo $count_baiviet; ?></p>
    <p>Số lượng người dùng: <?php echo $count_users; ?></p>
    
</div>