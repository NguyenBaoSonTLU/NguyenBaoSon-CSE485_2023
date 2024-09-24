<?php
// Kết nối CSDL từ file db.php
include '../Connect/db.php';

if (isset($_GET['ma_bviet'])) {
    $ma_bviet = intval($_GET['ma_bviet']);

    // Lấy thông tin bài viết từ cơ sở dữ liệu
    $sql = "SELECT * FROM baiviet WHERE ma_bviet = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $ma_bviet);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Không tìm thấy bài viết.";
            exit;
        }
        $stmt->close();
    } else {
        echo "Lỗi chuẩn bị câu lệnh: " . $conn->error;
        exit;
    }
} else {
    echo "ID bài viết không hợp lệ.";
    exit;
}

// Lấy danh sách thể loại
$categories = [];
$cat_sql = "SELECT ma_tloai, ten_tloai FROM theloai";
if ($cat_stmt = $conn->prepare($cat_sql)) {
    $cat_stmt->execute();
    $cat_result = $cat_stmt->get_result();
    while ($cat_row = $cat_result->fetch_assoc()) {
        $categories[] = $cat_row;
    }
    $cat_stmt->close();
} else {
    echo "Lỗi chuẩn bị câu lệnh thể loại: " . $conn->error;
}

// Lấy danh sách tác giả
$authors = [];
$auth_sql = "SELECT ma_tgia, ten_tgia FROM tacgia";
if ($auth_stmt = $conn->prepare($auth_sql)) {
    $auth_stmt->execute();
    $auth_result = $auth_stmt->get_result();
    while ($auth_row = $auth_result->fetch_assoc()) {
        $authors[] = $auth_row;
    }
    $auth_stmt->close();
} else {
    echo "Lỗi chuẩn bị câu lệnh tác giả: " . $conn->error;
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style_login.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="./">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="../index.php">Trang ngoài</a></li>
                        <li class="nav-item"><a class="nav-link active fw-bold" href="category.php">Thể loại</a></li>
                        <li class="nav-item"><a class="nav-link" href="author.php">Tác giả</a></li>
                        <li class="nav-item"><a class="nav-link" href="article.php">Bài viết</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Sửa thông tin bài viết</h3>
                <form action="process_edit_article.php" method="POST">
                    <input type="hidden" name="ma_bviet" value="<?php echo $ma_bviet; ?>">
                    
                    <label for="tieude">Tiêu đề:</label><br>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblTieude">Tiêu đề</span>
                        <input type="text" class="form-control" id="tieude" name="tieude" value="<?php echo htmlspecialchars($row['tieude'] ?? ''); ?>" required>
                    </div>

                    <label for="ten_bai_hat">Tên bài hát:</label><br>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblTenBaiHat">Tên bài hát</span>
                        <input type="text" class="form-control" id="ten_bhat" name="ten_bhat" value="<?php echo htmlspecialchars($row['ten_bhat'] ?? ''); ?>" required>
                    </div>

                    <label for="tomtat">Tóm tắt:</label><br>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblTomTat">Tóm tắt</span>
                        <textarea class="form-control" id="tomtat" name="tomtat" required><?php echo htmlspecialchars($row['tomtat'] ?? ''); ?></textarea>
                    </div>

                    <label for="noidung">Nội dung:</label><br>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblNoiDung">Nội dung</span>
                        <textarea class="form-control" id="noidung" name="noidung" required><?php echo htmlspecialchars($row['noidung'] ?? ''); ?></textarea>
                    </div>

                    <label for="ma_tloai">Mã thể loại:</label><br>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblMaTloai">Thể loại</span>
                        <select class="form-select" id="ma_tloai" name="ma_tloai" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['ma_tloai']; ?>" <?php echo $category['ma_tloai'] == $row['ma_tloai'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['ten_tloai']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <label for="new_tloai">Thêm thể loại mới:</label><br>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblNewTloai">Tên thể loại</span>
                        <input type="text" class="form-control" id="new_tloai" name="new_tloai">
                    </div>

                    <label for="ma_tgia">Mã tác giả:</label><br>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblMaTgia">Tác giả</span>
                        <select class="form-select" id="ma_tgia" name="ma_tgia" required>
                            <?php foreach ($authors as $author): ?>
                                <option value="<?php echo $author['ma_tgia']; ?>" <?php echo $author['ma_tgia'] == $row['ma_tgia'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($author['ten_tgia']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <label for="new_tgia">Thêm tác giả mới:</label><br>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblNewTgia">Tên tác giả</span>
                        <input type="text" class="form-control" id="new_tgia" name="new_tgia">
                    </div>

                    <input type="submit" value="Cập nhật" class="btn btn-primary">
                    <a href="article.php" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
</body>
</html>
