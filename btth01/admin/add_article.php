<?php
// Kết nối CSDL từ file db.php
include '../Connect/db.php';

// Lấy danh sách thể loại và tác giả
$result_theloai = $conn->query("SELECT * FROM theloai");
$result_tacgia = $conn->query("SELECT * FROM tacgia");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style_login.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Trang ngoài</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>

    </header>
    <main class="container mt-5 mb-5">
        <!-- <h3 class="text-center text-uppercase mb-3 text-primary">CẢM NHẬN VỀ BÀI HÁT</h3> -->
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Thêm mới bài viết </h3>
                <form action="process_add_article.php" method="POST">
    <div class="input-group mt-3 mb-3">
        <span class="input-group-text" id="lblTitle">Tên tiêu đề</span>
        <input type="text" class="form-control" id="ten_tieu_de" name="ten_tieu_de" required>
    </div>

    <div class="input-group mt-3 mb-3">
        <span class="input-group-text" id="lblSongName">Tên bài hát</span>
        <input type="text" class="form-control" id="ten_bhat" name="ten_bhat" required>
    </div>

    <div class="input-group mt-3 mb-3">
        <span class="input-group-text" id="lblCatType">Thể loại</span>
        <select class="form-control" id="ma_tloai" name="ma_tloai" required>
                        <option value="">Chọn loại</option>
                        <?php
                        // Kiểm tra nếu có dữ liệu và lặp qua từng hàng
                        if ($result_theloai->num_rows > 0) {
                            while ($row = $result_theloai->fetch_assoc()) {
                                echo "<option value='" . $row['ma_tloai'] . "'>" . $row['ten_tloai'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Không có thể loại nào</option>";
                        }
                        ?>
                    </select>
    </div>
    <div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="lblAuthorName">Tên tác giả</span>
    <select class="form-control" id="ma_tgia" name="ma_tgia" required>
                        <option value="">Chọn tác giả</option>
                        <?php
                        // Kiểm tra nếu có dữ liệu và lặp qua từng hàng
                        if ($result_tacgia->num_rows > 0) {
                            while ($row = $result_tacgia->fetch_assoc()) {
                                echo "<option value='" . $row['ma_tgia'] . "'>" . $row['ten_tgia'] . "</option>"; // Đã sửa thành ma_tgia
                            }
                        } else {
                            echo "<option value=''>Không có tác giả</option>";
                        }
                        ?>
                    </select>
                    </div>

<div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="lblSummary">Tóm tắt</span>
    <textarea class="form-control" id="tom_tat" name="tom_tat" required></textarea>
</div>

<div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="lblContent">Nội dung</span>
    <textarea class="form-control" id="noidung" name="noidung" required></textarea>
</div>

<div class="input-group mt-3 mb-3">
        <span class="input-group-text" id="lblImage">Hình ảnh</span>
        <input type="file" class="form-control" id="hinhanh" name="hinhanh" accept="image/*" required>
    </div>

<div class="input-group mt-3 mb-3">
    <span class="input-group-text" id="lblDate">Ngày viết</span>
    <input type="date" class="form-control" id="ngayviet" name="ngayviet" required>
</div>

<div class="form-group float-end">
    <input type="submit" value="Thêm" class="btn btn-success">
    <a href="article.php" class="btn btn-warning">Quay lại</a>
</div>
</form>

            </div>
        </div>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary  border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>